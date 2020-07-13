$(document).ready(function(){
    $('input#file').change(function(){
        file_send();
    });
    $('#filedelete').click(function(){
        file_delete();
        return false;
    });
});


function file_send(){
 
    //ajaxでのcsrfトークン送信
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
 
    //アップロードファイルの入力値を取得する。
    var fileData = document.getElementById("file").files[0];
 
    //フォームデータを作成する。(送信するデータ)
    var form = new FormData();
 
    //フォームデータにテキストの内容、アップロードファイルの内容を格納する。
    form.append( "file", fileData );//第一パラメータはname属性に当たるもの
    
    //POST送信する。
    $.ajax({
        type: 'post',
        url: '/upload/',
        data: form,
        processData : false,
        contentType : false,//あえてfalseとする。これでちゃんとmultipart/form-dataで送られる
        
        //成功の場合、以下を行う。
        success: function(data){
            //console.log(data);
            if(!data.error){
                $('input[name="image"]').val(data.filename);
                $('#pic_thumb').attr('src' , '/user_images/' + data.filename);
            }else{
                alert(data.error);
            }
        },
        
        //失敗の場合、以下を行う。
        error : function(){
            alert('通信ができない状態です。');
        }
    });
}

function file_delete(){

    file = $('input[name="image"]').val();

    //ajaxでのcsrfトークン送信
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

    //POST送信する。
    $.ajax({
        type: 'post',
        url: '/upload/destroy',
        data: {filename : file },
        
        //成功の場合、以下を行う。
        success: function(data){
            //console.log(data);
            if(!data.error){
                $('input[name="image"]').val('');
                $('#pic_thumb').attr('src' , '');
                $('#file').val('');
            }else{
                alert(data.error);
            }
        },
        
        //失敗の場合、以下を行う。
        error : function(){
            alert('通信ができない状態です。');
        }
    });
}