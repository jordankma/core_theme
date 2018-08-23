<?php
namespace Dhcd\Document\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Document\App\Repositories\TagRepository;
use Dhcd\Document\App\Models\Tag;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Auth;
use Validator;

class TagController extends Controller
{

    public function __construct(TagRepository $tagRepository)
    {
        parent::__construct();
        $this->tag = $tagRepository;
    }

    public function create()
    {
        return view('DHCD-DOCUMENT::modules.document.tag.create');
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all('name'), [
            'name' => 'required',
        ]);
        if (!$validator->fails()) {
            $tag = Tag::create([
                'name' => $request->name,
                'alias' => $this->to_slug($request->name)
            ]);
            if ($tag->tag_id) {               
                activity('dhcd_tag')->performedOn($tag)->withProperties($request->all())->log('User: :' . Auth::user()->email . ' - Add tag - dhcd_tag: ' . $tag->tag_id . ', name: ' . $tag->name);
                return redirect()->route('dhcd.document.tag.create')->with('success', 'Thêm danh mục thành công');
            }
            return redirect()->route('dhcd.document.tag.create')->withErrors(['Thêm danh mục không thành công']);
        } else {

            return redirect()->route('dhcd.document.tag.create')->withErrors(['Vui lòng kiểm tra lại dữ liệu nhập vào']);
        }
    }

    public function edit(Request $request) {
        if (empty($request->only('tag_id'))) {
            return redirect()->route('dhcd.document.tag.create')->withErrors(['Không tìm thấy tag cần sửa']);
        }
        $tag = $this->tag->find($request->tag_id);      
        
        return view('DHCD-DOCUMENT::modules.document.tag.edit', compact('tag'));        
    }

    public function update(Request $request){
        if (empty($request->only('tag_id', 'name'))) {
            return redirect()->route('dhcd.document.tag.create')->withErrors(['Không tìm thấy tag cần sửa']);
        }
        $tag = $this->tag->find($request->tag_id);
        $tag->name = $request->name;
        $tag->alias = $this->to_slug($request->name);  
        if($tag->save()){
            activity('dhcd_tag')->performedOn($tag)->withProperties($request->all())->log('User: :' . Auth::user()->email . ' - Edit tag - dhcd_tag: ' . $tag->tag_id . ', name: ' . $tag->name);
            return redirect()->route('dhcd.document.tag.edit',['tag_id' => $tag->tag_id])->with('success', 'Cập nhật tag thành công');
        }
        else{
            return redirect()->route('dhcd.document.tag.edit',['tag_id' => $tag->tag_id])->with('error', 'Cập nhật tag không thành công');
        }
    }

    public function manage(){
        $tags = $this->tag->all();       
        return view('DHCD-DOCUMENT::modules.document.tag.manage', compact('tags'));
    }

    public function delete(Request $request) {

        if (empty($request->only('tag_id'))) {
            return redirect()->route('dhcd.document.tag.manage')->withErrors(['Không tìm thấy tag cần xóa']);
        }
        $tag = $this->tag->find($request->tag_id);        
        $tag->deleted_at = date('Y-m-d H:s:i');
        $tag->save();

        activity('dhcd_tag')->performedOn($tag)->withProperties($request->all())->log('User: :' . Auth::user()->email . ' - Delete tag - dhcd_tag: ' . $tag->tag_id . ', name: ' . $tag->name);
        
        return redirect()->route('dhcd.document.tag.manage')->with('success', 'Xóa danh tag thành công');
    }

    public function log(Request $request) {
        
        $model = 'dhcd_tag';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
                        ]);
                        
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                            ['log_name', $model],
                            ['subject_id', $request->subject_id]
                        ])->get();

                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    protected function to_slug($str)
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }
}