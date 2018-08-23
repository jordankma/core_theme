<?php

namespace Dhcd\Document\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Document\App\Repositories\DocumentTypeRepository;
use Dhcd\Document\App\Models\DocumentType;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Cache,Auth;

class DocumentTypeController extends Controller
{
    
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    
    public function __construct(DocumentTypeRepository $documentTypeRepository) {
        parent::__construct();
        $this->documentType = $documentTypeRepository;
    }
                    
    public function edit(Request $request){              
        $types = $this->documentType->getTypes();        
        return view('DHCD-DOCUMENT::modules.document.type.edit',compact('types'));
    }
    
    public function update(Request $request){
                        
        if(empty($request->image) || empty($request->text) || empty($request->video) || empty($request->audio)){
            return redirect()->back()->withInput()->withErrors(['Cập nhật không thành công']);
        }
        $image_extentions = json_encode($request->image);
        $text_extentions = json_encode($request->text);
        $video_extentions = json_encode($request->video);
        $audio_extentions = json_encode($request->audio);
        
        if(!empty($image_extentions)){
            DocumentType::where('type','image')->update(['extentions' => $image_extentions]);
        }
        if(!empty($text_extentions)){
            DocumentType::where('type','text')->update(['extentions' => $text_extentions]);
        }
        if(!empty($video_extentions)){
            DocumentType::where('type','video')->update(['extentions' => $video_extentions]);
        }
        if(!empty($audio_extentions)){
            DocumentType::where('type','audio')->update(['extentions' => $audio_extentions]);
        }
        $this->resetCache();
        return redirect()->back()->withInput()->with('success','Cập nhật thông tin cấu hình kiểu tài liệu thành công');        
    }
                    
    public function resetCache(){
        Cache::forget('document_type_list');
    }
    
    
}