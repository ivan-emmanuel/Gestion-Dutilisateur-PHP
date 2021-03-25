    <?php

    use Application\Configs;
    use Application\Paths;

    function app_config(?string $param = null){
        $param = strtoupper($param);
        if( !empty($param) ){
            return Configs::Instance()->getAppConfig()->get($param);
        }
        return Configs::Instance()->getAppConfig();
    }


    function html_field($name,$title,$type='text',$default = "")
    {
        $posts_data = session_instance()->read("_data");
        $default = ($type != 'password' && !empty($posts_data[$name]) )? $posts_data[$name] : $default;
        echo "<div class=\"form-group\">
                        <label for=\"$name\">$title</label>
                        <input type=\"$type\" class=\"form-control   \" name='$name' value='$default'>
                    </div>";
    }

    function textarea_field($name,$title,$default = "")
    {
        $posts_data = session_instance()->read("_data");
        $default = ( !empty($posts_data[$name]) )? $posts_data[$name] : $default;
        echo "<div class=\"form-group\">
                            <label for=\"$name\">$title</label>
                            <textarea  class=\"form-control  \" name='$name' >$default</textarea>
                        </div>";
    }

    function text_field ($name,$title,$default = "",array $classes = [])
    {
        html_field($name,$title,'text',$default,$classes);
    }

    function email_field ($name,$title,$default = "",array $classes = [])
    {
        html_field($name,$title,'email',$default,$classes);
    }


    function password_field ($name,$title,$default = "",array $classes = [])
    {
        html_field($name,$title,'password',$default,$classes);
    }

    function modal_tags($modal_id, $modal_title){
        echo '
                <div id="'.$modal_id.'" class="pt-5">
                
                <div class="container">	
                        <!--"THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID-->
                <div class="row"> 
                    <h3 class="col-lg-6">'.$modal_title.'</h3>
                    <div class="col-lg-6 text-right">
                        <a class="close-'.$modal_id.' btn btn-danger" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
            ';
    }

    function close_modal_tags(){
        echo "
                </div>			
    
            </div>
            ";
    }


    function bs_modal_tags($modal_id, $modal_title){
        echo "
            <div id='$modal_id' class=\"modal fade\" tabindex=\"-1\" role=\"dialog\">
                <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\">$modal_title</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">&times;</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">
        ";
    }


    function bs_modal_tags_close(){
        echo "
                     </div>
                </div>
            </div>
        </div>
        ";
    }

    function load_view($view = null,$vars = [])
    {
        extract($vars);
        require Paths::Instance()->View($view);
    }

