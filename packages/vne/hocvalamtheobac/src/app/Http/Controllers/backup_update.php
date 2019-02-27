//   $member = Member::where('member_id',$member_id)->first();
    //   if(empty($member)){
    //     $member = new Member();
    //     $data_request = $request->all();
    //     dd($data_request);
    //     if(!empty($data_request)){
    //       foreach ($data_request as $key => $value) {
    //         $member->addColumn('vne_member',$key);
    //         if(gettype($request->input($key))=='array'){
    //           $member->$key = json_encode($request->input($key));
    //         } else{
    //           $member->$key = $request->input($key); 
    //         }
    //       }
    //     }
    //     if($member->save()){
          
    //       $member->is_reg = '1';
    //       $member->update();
    //       $data = $member->getAttributes();
    //       $data = json_encode($data);
    //       $data_encrypt = $this->my_simple_crypt($data);
    //       try {
    //           $url = config('app.url');
    //           $url = 'http://gthd.vnedutech.vn';
    //           $result = file_get_contents($url . '/admin/api/contest/candidate_register?data='. $data_encrypt);
    //           $result = json_decode($result);
    //           if($result->status == true){
    //               $member->sync_mongo = '1';
    //               $member->update();
    //               return redirect()->route('index');
    //           }
    //           else{
    //               return redirect()->route('frontend.member.register.show');
    //           }
    //       } catch (Exception $e) {
              
    //       }
    //       return redirect()->route('index');
    //     }
    //   } else{
    //     return redirect()->route('index');  
    //   }