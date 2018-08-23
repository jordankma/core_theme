<?php

namespace Dhcd\Document\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Document\App\Models\DocumentCate;

use Dhcd\Document\App\Models\DocumentCateHasMember;
use Dhcd\Member\App\Models\Member;

use Dhcd\Document\App\Models\Tag;
use Dhcd\Document\App\Models\TagItem;
use Dhcd\Document\App\Repositories\DocumentCateRepository;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,
    Cache,
    Auth,DB;

class DocumentCateController extends Controller {

    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(DocumentCateRepository $documentCateRepository) {
        parent::__construct();
        $this->documentCate = $documentCateRepository;
    }

    public function manage(Request $request) {
        
        $objCate = new DocumentCate();
        $cates = $this->documentCate->getCates();        
        $parents = $this->_buildCate($this->documentCate->getCates());

        return view('DHCD-DOCUMENT::modules.document.cate.manage', compact('cates', 'objCate', 'parents'));
    }

    public function add(Request $request) {
       
        $objCate = new DocumentCate();
        $cates = $this->documentCate->getCates();
        $tags = Tag::orderBy('tag_id', 'desc')->get()->toArray();
        return view('DHCD-DOCUMENT::modules.document.cate.add', compact('cates', 'objCate','tags'));
    }

    public function create(Request $request) {
        
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'icon' => 'required'
                        ], $this->messages);
        if (!$validator->fails()) {
            $cateExits = DocumentCate::where(['alias' => $this->to_slug($request->name)])->get()->toArray();
            if($cateExits){                
                return redirect()->back()->withInput()->withErrors(['Danh mục đã tồn tại']);
            }
            $cate = DocumentCate::create([
                        'name' => $request->name,
                        'alias' => $this->to_slug($request->name),
                        'icon' => $request->icon,
                        'sort' => $request->sort,
                        'descript' => $request->descript,
                        'parent_id' => $request->parent_id
            ]);
            //save tag
            if ($cate->document_cate_id) {
                if(!empty($request->tag)){
                    foreach($request->tag as $tag){
                        $insertTag[] = [
                            'document_cate_id' => $cate->document_cate_id,
                            'tag_id' => $tag
                        ]; 
                    }
                   
                    if(!empty($insertTag)){
                        TagItem::insert($insertTag);
                    }
                }
                $this->resetCache();
                activity('document_cates')->performedOn($cate)->withProperties($request->all())->log('User: :' . Auth::user()->email . ' - Add document cate - document_cate: ' . $cate->document_cate_id . ', name: ' . $cate->name);
                return redirect()->route('dhcd.document.cate.add')->with('success', 'Thêm danh mục thành công');
            }
            return redirect()->route('dhcd.document.cate.add')->withErrors(['Thêm danh mục không thành công']);
        } else {

            return redirect()->route('dhcd.document.cate.add')->withErrors(['Vui lòng kiểm tra lại dữ liệu nhập vào']);
        }
    }

    public function edit(Request $request) {
        if (empty($request->only('document_cate_id'))) {
            return redirect()->route('dhcd.document.cate.manage')->withErrors(['Không tìm thấy danh mục cần sửa']);
        }
        $objCate = new DocumentCate();
        $cates = $this->documentCate->getCates();
        $cate = $this->documentCate->find($request->document_cate_id);
        $tags = Tag::orderBy('tag_id', 'desc')->get()->toArray();
        
        return view('DHCD-DOCUMENT::modules.document.cate.edit', compact('cate', 'cates', 'objCate', 'tags'));
    }

    public function update(Request $request) {

        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'document_cate_id' => 'required'
                        ], $this->messages);
        if (!$validator->fails()) {
            $cateExits = DocumentCate::where('alias',$this->to_slug($request->name))->where('document_cate_id','<>',$request->document_cate_id)->get()->toArray();
            if($cateExits){                
                return redirect()->back()->withInput()->withErrors(['Danh mục đã tồn tại']);
            }
            $cate = $this->documentCate->find($request->document_cate_id);
            $cate->name = $request->name;
            $cate->alias = $this->to_slug($request->name);
            $cate->sort = $request->sort;
            $cate->descript = $request->descript;
            if ($cate->document_cate_id != (int) $request->parent_id) {
                $cate->parent_id = $request->parent_id;
            }
            if (!empty($request->icon)) {
                $cate->icon = $request->icon;
            }
            $cate->save();
            // save tag
            if(!empty($request->tag)){
                TagItem::where('document_cate_id',$cate->document_cate_id)->delete();
                foreach($request->tag as $tag){
                    $insertTag[] = [
                        'document_cate_id' => $cate->document_cate_id,
                        'tag_id' => $tag
                    ]; 
                }
               
                if(!empty($insertTag)){
                    TagItem::insert($insertTag);
                }
            }

            $this->resetCache();



            activity('document_cates')->performedOn($cate)->withProperties($request->all())->log('User: :' . Auth::user()->email . ' - Edit document cate - document_cate: ' . $cate->document_cate_id . ', name: ' . $cate->name);
            return redirect()->route('dhcd.document.cate.manage')->with('success', 'Cập nhật danh mục thành công');
        } else {
            return redirect()->route('dhcd.document.cate.edit', ['document_cate_id' => $request->document_cate_id])->withErrors(['Vui lòng kiểm tra lại dữ liệu nhập vào']);
        }
    }

    public function delete(Request $request) {

        if (empty($request->only('document_cate_id'))) {
            return redirect()->route('dhcd.document.cate.manage')->withErrors(['Không tìm thấy danh mục cần xóa']);
        }
        $cate = $this->documentCate->find($request->document_cate_id);
        $cate->status = 0;
        $cate->deleted_at = date('Y-m-d H:s:i');
        $cate->save();

        activity('document_cates')->performedOn($cate)->withProperties($request->all())->log('User: :' . Auth::user()->email . ' - Delete document cate - document_cate: ' . $cate->document_cate_id . ', name: ' . $cate->name);
        $this->resetCache();
        return redirect()->route('dhcd.document.cate.manage')->with('success', 'Xóa danh mục thành công');
    }

    public function log(Request $request) {

        $model = 'document_cates';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
                        ], $this->messages);
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

    public function resetCache() {
        Cache::forget('document_cates_list');
    }

    protected function _buildCate($cates) {
        $datas = [];
        foreach ($cates as $cate) {
            $datas[$cate['document_cate_id']] = [
                'name' => $cate['name'],
                'icon' => $cate['icon'],
                'parent_id' => $cate['parent_id']
            ];
        }
        return $datas;
    }

    protected function to_slug($str) {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '', $str);
        return $str;
    }

    public function getListCategory(){
        $cates = $this->documentCate->getCates();
        return $this->_buildTree($cates);
    }
    
    public function _buildTree($cates, $parentId = 0) {
        $branch = array();

        foreach ($cates as $cate) {
            if ($cate['parent_id'] == $parentId) {
                $children = self::_buildTree($cates, $cate['document_cate_id']);
                if ($children) {
                    $cate['children'] = $children;
                }
                $branch[] = (object)$cate;
            }
        }

        return $branch;
    }
    public function getAllCategory(){
       $cates = $this->documentCate->getCates();
       return $cates;
   }

   // add xoa tung member 
    public function createMember(Request $request){
        $validator = Validator::make($request->all(), [
            'document_cate_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $document_cate_id = $request->input('document_cate_id');
            return view('DHCD-DOCUMENT::modules.document.cate.addMember',compact('document_cate_id')); 
        } else {
            return $validator->messages();
        }
    }

    public function addMember(Request $request){
        $validator = Validator::make($request->all(), [
            'document_cate_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {

            $document_cate_id = $request->input('document_cate_id');
            $members = $request->list_members;
            $document_cates = $this->documentCate->find($document_cate_id);
            if (null != $document_cates && !empty($members)) {
                $data_insert = array();
                if(!empty($members)){
                    foreach ($members as $key => $member) {
                        if (!DocumentCateHasMember::where([
                            'document_cate_id' => $document_cate_id,
                            'member_id' => $member,
                        ])->exists()
                        )
                        {
                            $data_insert[] = [
                                'document_cate_id' => $document_cate_id,
                                'member_id' => $member
                            ];
                        }
                    }
                }
                if(!empty($data_insert)){
                    DB::table('dhcd_document_cate_has_member')->insert($data_insert);
                }
                activity('document_cates')
                    ->performedOn($document_cates)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add single member document - document_cate_id: :properties.document_cate_id, name: ' . $document_cates->name);
                return redirect()->route('dhcd.document.cate.create.member',['document_cate_id' => $document_cate_id])->with('success', trans('dhcd-document::language.messages.success.status'));
            }
            else{
                return redirect()->route('dhcd.document.cate.create.member',['document_cate_id' => $document_cate_id])->with('error', trans('dhcd-document::language.messages.error.status'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function getModalDeleteMember(Request $request)
    {
        $model = 'document_cate';
        $type = 'delete_member';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'document_cate_id' => 'required|numeric',
            'member' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.document.cate.delete.member', ['document_cate_id' => $request->input('document_cate_id'),'member' => $request->input('member')]);
                return view('DHCD-DOCUMENT::modules.document.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-DOCUMENT::modules.document.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function deleteMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_cate_id' => 'required|numeric',
            'member' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            
            $document_cate_id = $request->input('document_cate_id');
            $document_cates = $this->documentCate->find($document_cate_id);
            $members = explode(",",$request->input('member'));
            if (!empty($members)) {
                foreach ($members as $key => $member) {
                    DB::table('dhcd_document_cate_has_member')->where(['document_cate_id' => $document_cate_id,'member_id' => $member])->delete();
                }
                activity('document_cates')
                    ->performedOn($document_cates)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Delete member document_cates - document_cate_id: :properties.document_cate_id, name: ' . $document_cates->name);

                return redirect()->route('dhcd.document.cate.create.member',['document_cate_id' => $document_cate_id])->with('success', trans('dhcd-document::language.messages.success.delete'));
            } else {
                return redirect()->route('dhcd.document.cate.create.member',['document_cate_id' => $document_cate_id])->with('error', trans('dhcd-document::language.messages.error.delete'));
            }

        } else {
            return $validator->messages();
        }   
    }

    public function dataMember(Request $request)
    {
        $document_cate_id = $request->input('document_cate_id');
        $document_cate = DocumentCate::where('document_cate_id', $document_cate_id)->with('getMember')->first();
        $members = $document_cate->getMember;
        return Datatables::of($members)
            ->addIndexColumn()
            ->addColumn('actions', function ($members) use ($document_cate_id) {
                $actions = '<input id="'.$members->member_id.'" type="checkbox" value="" class="select-member">';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function searchMember(Request $request) {
        $data = [];
        if ($request->ajax()) {
            $keyword = $request->input('keyword');
            $document_cate_id = $request->input('document_cate_id');
            if(!empty($keyword)){
                $list_member_old = DocumentCateHasMember::where('document_cate_id',$document_cate_id)->select('member_id')->get();
                $list_members = Member::where('name', 'like', '%' . $keyword . '%')->whereNotIn('member_id', $list_member_old)->get();
                if(!empty($list_members)){
                    foreach($list_members as $member){
                        $data[] = [
                            'name' => $member->name,
                            'member_id' => $member->member_id,
                            'position_current' => $member->position_current
                        ];
                    }
                }
            }
        }
        echo json_encode($data);
    }
    // add xoa tung member 
}
