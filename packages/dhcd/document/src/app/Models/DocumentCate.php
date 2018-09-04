<?php

namespace Dhcd\Document\App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dhcd\Document\App\Models\Tag;

class DocumentCate extends Model {
    use SoftDeletes;
    protected $_html;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_document_cates';

    protected $primaryKey = 'document_cate_id';

    protected $fillable = ['name','parent_id','icon','alias', 'descript', 'sort'];
    
    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    
    public function getTags(){
        return $this->belongsToMany(Tag::class, 'dhcd_tags_item','document_cate_id', 'tag_id');
    }
    
    public function getMember(){
        return $this->belongsToMany('Dhcd\Member\App\Models\Member', 'dhcd_document_cate_has_member', 'document_cate_id', 'member_id');
    }

    public static function showCategories($cates,$parent_current = 0,$prarent_id = 0, $char = ''){
             
        foreach($cates as $key => $item){
            if($item['parent_id'] == $prarent_id){
                if($item['document_cate_id'] == $parent_current )
                {
                    echo  '<option value="'.$item['document_cate_id'].'" selected>'.$char.' '.htmlspecialchars($item['name']).'</option>';                
                }
                else{
                    echo  '<option value="'.$item['document_cate_id'].'" >'.$char.' '.htmlspecialchars($item['name']).'</option>';  
                }
                unset($cates[$key]);
                self::showCategories($cates,$parent_current,$item['document_cate_id'],$char.'|--');
            }
        }
       
    }
    
    public static function showIsCategories($cates, $document_cate_id = [], $prarent_id = 0, $char = ''){
        
        foreach($cates as $key => $item){
            if($item['parent_id'] == $prarent_id){
                if(in_array($item['document_cate_id'], $document_cate_id))
                {
                    echo  '<option  value="'.$item['document_cate_id'].'" selected>'.$char.' '.htmlspecialchars($item['name']).'</option>';                
                }
                else{
                    echo  '<option value="'.$item['document_cate_id'].'" >'.$char.' '.htmlspecialchars($item['name']).'</option>';  
                }
                 
            }
            else{
                if(in_array($item['document_cate_id'], $document_cate_id))
                {
                    echo  '<option  value="'.$item['document_cate_id'].'" selected>'.$char.' '.htmlspecialchars($item['name']).'</option>';                
                }
                else{
                    echo  '<option value="'.$item['document_cate_id'].'" >'.$char.' '.htmlspecialchars($item['name']).'</option>';  
                } 
            }
            unset($cates[$key]);
            self::showCategories($cates, $document_cate_id, $item['document_cate_id'], $char.'|--');  
            
        }
        
       
    }
    
    public static function showIsTableCategories($cates, $parents, $USER_LOGGED, $parent_id = 0, $char = ''){
        
        foreach ($cates as $key => $item)
        {
            // Nếu là chuyên mục con thì hiển thị
            if ($item['parent_id'] == $parent_id)
            {
                
                 echo '<tr>';                    
                    echo '<td>';
                        echo "<img width='50px' src='".$item["icon"]."' >";
                    echo '</td>';               
                    echo '<td>';
                        echo $char . ' '.htmlspecialchars($item['name']);
                    echo '</td>';               
                    echo '<td>';
                        echo !empty($parents[$item['parent_id']]) ? $parents[$item['parent_id']]['name'] : 'Root';
                    echo '</td>';
                    echo '<td>';
                        if($USER_LOGGED->canAccess('dhcd.document.doc.log')){
                            echo "<a href='".route('dhcd.document.cate.log',['type' => 'document_cates', 'subject_id' => $item['document_cate_id']])."' data-toggle='modal' data-target='#log'><i class='livicon' data-name='info' data-size='18' data-loop='true' data-c='#F99928' data-hc='#F99928' title='log document'></i></a>";
                        }
                        if($USER_LOGGED->canAccess('dhcd.document.cate.edit')){
                            echo "<a href='".route('dhcd.document.cate.edit',['document_cate_id' => $item['document_cate_id']])."' ><i class='livicon' data-name='edit' data-size='18' data-loop='true' data-c='#428BCA' data-hc='#428BCA' title='edit'></i></a>";
                        } // 
                        if($USER_LOGGED->canAccess('dhcd.document.cate.delete')){
                            echo "<a href='".route('dhcd.document.cate.delete',['document_cate_id' => $item['document_cate_id']])."'  onclick='return confirm(".'"'."Bạn có chắc chắn muốn xóa?".'"'.")'><i class='livicon' data-name='trash' data-size='18' data-loop='true' data-c='#f56954' data-hc='#f56954' title='delete'></i></a>";
                        }
                        if($USER_LOGGED->canAccess('dhcd.document.cate.create.member')){
                            echo "<a href='".route('dhcd.document.cate.create.member',['document_cate_id' => $item['document_cate_id']])."' ><i class='livicon' data-name='add member' data-size='18' data-loop='true' data-c='#428BCA' data-hc='#428BCA' title='add member'></i></a>";
                        } //
                    echo '</td>';
                echo '</tr>';
                
                // Xóa chuyên mục đã lặp
                unset($cates[$key]);

                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                self::showIsTableCategories($cates, $parents, $USER_LOGGED ,$item['document_cate_id'], $char.'|---');
            }
        }
    }
     
}
