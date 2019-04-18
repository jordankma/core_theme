<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ContestEnvironment;
use Contest\Contestmanage\App\Http\Requests\ContestClientRequest;
use Contest\Contestmanage\App\Models\ContestClient;
use Contest\Contestmanage\App\Models\ContestSeason;
use Contest\Contestmanage\App\Models\ContestSetting;
use Contest\Contestmanage\App\Models\SeasonConfig;
use Contest\Contestmanage\App\Repositories\ContestClientRepository;
use Contest\Contestmanage\App\Repositories\ContestSettingRepository;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Filesystem\Filesystem;
use Validator;
use Yajra\Datatables\Datatables;

class ContestClientController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    public function __construct(ContestClientRepository $clientRepository, Filesystem $files, ContestSettingRepository $contestSettingRepository)
    {
        parent::__construct();
        $this->client = $clientRepository;
        $this->files = $files;
        $this->setting = $contestSettingRepository;
    }


    public function add(ContestClientRequest $request)
    {
        $domain = str_replace('http://','',config('app.url'));
        $client = new ContestClient();
        $client->name = $request->name;
        $client->description = $request->description;
        $client->environment = $request->environment;
        $number = ContestClient::where('environment', $request->environment)->count();
        $number = $number + 1;
        $client->width = $request->width;
        $client->height = $request->height;
        $config = '';
        if (!empty($request->config)) {
            $config = [];
            foreach ($request->config['name'] as $key => $value) {
                $config[] = [
                    'name' => $value,
                    'id' => $request->config['id'][$key],
                    'value' => $request->config['value'][$key]
                ];
            }
            $config = json_encode($config);
        }
        $client->config = $config;
        if (!empty($request->file('resource'))) {
            $file = $request->file('resource');
            $resource_name = 'client_' . $request->environment . '_zip_' . time();
            $resource_extension = $file->getClientOriginalExtension();
            $resource_target = $resource_name . '.' . $resource_extension;
            if ($resource_extension == 'zip') {
                $destinationPath = 'zip/';
                $file->move($destinationPath, $resource_target);
            } else {
                return redirect()->back()->with('error', 'Resource không hợp lệ, vui lòng chỉ upload file zip');
            }
            $dir = $domain.'/client/' . $request->environment . $number;
            if (!$this->files->isDirectory($dir)) {
                mkdir($dir, 0755, true);
            }


            try {
//            echo "<pre>";print_r('unzip zip/'. $resource_target .' -d client/'.$request->environment.'/');echo "</pre>";die;
//            shell_exec('cd ../ && unzip public/zip/'. $resource_target .' -d '.$request->environment.'/');
//            dd(shell_exec('cd client/'.$request->environment .' && unzip '.$file->getRealPath()));
//            dd(shell_exec('unzip -d zip/'. $resource_target .' 2>&1'));
                shell_exec('unzip zip/' . $resource_target . ' -d '. $dir);
//            dd(shell_exec('ls 2>&1'));
//            dd(shell_exec('cd zip && unzip '. $resource_target .' -d /client 2>&1'));
//            dd(shell_exec('cd zip && dir 2>&1'));

//            dd(shell_exec('cp -r files/config/client/index.php client/'.$request->environment.'/ 2>&1'));
                shell_exec('cp files/config/client/index.php '.$dir);
                $config = '<script src="'.asset($dir.'/res/loading.js').'"></script>';
                $config .= '<canvas id="gameCanvas" width="' . $request->width . 'px" height="' . $request->height . 'px"></canvas>';
                if (!empty($request->config)) {
                    foreach ($request->config['name'] as $key => $value) {
                        $config .= '<input type="hidden" name="' . $value . '" id="' . $request->config['id'][$key] . '"';
                        if(!empty($request->config['value'][$key])){
                            $config .= ' value="'. $request->config['value'][$key] .'"/>';
                        }
                        else{
                            $config .= ' value="<?php echo $_GET[\'' . $request->config['name'][$key] . '\'] ?>"/>';
                        }
                    }
                }
//            $config .= '<script cocos src="game.min.js?v=0.0.1' . $request->version . '"></script>';
                $config .= '<script cocos src="'.asset($dir.'/game.min.js?v=0.0.1').'"></script>';
                try {
                    $index = file($dir . '/index.php', FILE_IGNORE_NEW_LINES);
                    array_splice($index, 16, 0, $config);
                    file_put_contents($dir . '/index.php', join("\n", $index));
                } catch (\Exception $e) {

                }

                $client->resource_path = $dir;
                $client->save();
                activity('contest_client')
                    ->performedOn($client)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add client - name: :properties.name, season_id: ' . $client->client_id);

                return redirect()->route('contest.contestmanage.contest_client.manage')->with('success', trans('contest-contestmanage::language.messages.success.create'));
            } catch (\Exception $e) {
                echo "<pre>";
                print_r($e->getMessage());
                echo "</pre>";
                die;
                return redirect()->route('contest.contestmanage.contest_client.manage')->with('error', trans('contest-contestmanage::language.messages.error.create'));
            }
        } else {
            return redirect()->route('contest.contestmanage.contest_client.manage')->with('error', trans('contest-contestmanage::language.messages.error.create'));
        }
    }

    public function create()
    {
        $data_view = [
            'environment' => $this->setting->getSettingData('environment')
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_client.create', $data_view);
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->client->find($product_id);

        if (null != $card_product) {
            $this->client->delete($product_id);

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $card_product->product_name);

            return redirect()->route('contest.contestmanage.contest_client.manage')->with('success', trans('contest-contestmanage::language.messages.success.delete'));
        }
        else {
            return redirect()->route('contest.contestmanage.contest_client.manage')->with('error', trans('contest-contestmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_client.manage');
    }

    public function show(Request $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->client->find($product_id);
        $data = [
            'card_product' => $card_product,
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_client.edit', $data);
    }

    public function update(CardProductRequest $request)
    {
        $product_id = $request->input('product_id');
        $card_product = $this->client->find($product_id);
        $card_product->product_name =$request->input('name');
        $card_product->product_code=strtoupper($request->input('code'));
        $card_product->description=$request->input('description');
        if ($card_product->save()) {

            activity('cardProduct')
                ->performedOn($card_product)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update cardProduct - product_id: :properties.product_id, name: :properties.product_name');

            return redirect()->route('contest.contestmanage.contest_client.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
        } else {
            return redirect()->route('contest.contestmanage.contest_client.show', ['product_id' => $request->input('product_id')])->with('error', trans('contest-contestmanage::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'cardProduct';
        $tittle = 'Xác nhận xóa';
        $type = $this->client->find($request->input('product_id'));
        $content = 'Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.contest_client.delete', ['product_id' => $request->input('product_id')]);
                return view('contest-contestmanage::modules.cardmanage.includes.modal_confirmation', compact('error','tittle','content', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'contest_client';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data(Request $request)
    {
        return Datatables::of($this->client->findAll())
            ->addColumn('actions', function ($client) {
                $actions = '<a href=' . route('contest.contestmanage.contest_client.log', ['type' => 'contest_client', 'id' => $client->client_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log client"></i></a>';
//                        <a href=' . route('contest.contestmanage.contest_client.confirm-delete', ['product_id' => $card_product->product_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete cardProduct"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function change(Request $request){
        $res = [];
        if(!empty($request->client_id)){
            $client = $this->client->find((int)$request->client_id);
            if(!empty($client)){
                $current_client = ContestClient::where('status', '1')->get();
                if(!empty($current_client)){
                    foreach ($current_client as $key => $item){
                        $item->status = '0';
                        $item->update();
                    }
                }
                $client->status = '1';
                if($client->update()){
                     $res['success'] = true;
                }
                else {
                     $res['success'] = false;
                }
            }
        }
        return response()->json($res);
    }



}