<?php

    

    class Footer {
        function __construct(){
            $params = func_get_args();
            $num_params = func_num_args();
    
            $function_construct = '__construct'.$num_params;
    
            if (method_exists($this,$function_construct) && $num_params==1) {
                call_user_func_array(array($this,$function_construct),$params);
            }
        }

        function __construct1($message){
            
            $this->message = $message;
            $this->pinta();
        }


    function pinta(){        

        ?>
                </div>
            </div>
            
            <footer class="footer">
                    <div class="row align-items-center justify-content-xl-between">
                        <div class="col-xl-6">
                            
                        </div>
                        <div class="col-xl-6">
                            
                        </div>
                    </div>
                </footer>
                

                </div>
            </div>

            <?php if(isset($_SESSION['type_message']) && isset($_SESSION['text_message'])) { ?>
                <div class="toast toast-def" id="toast" style="position: absolute; margin: auto; top: 40vh; left: 43vw; min-width: 400px; min-height: 100px;" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
            <div class="toast-header" style="<?php if($_SESSION['type_message']) { ?> background-color: rgba(189, 253, 157, 0.85); <?php } else { ?> background-color: rgba(255, 89, 89, 0.85); <?php } ?> color: #444444;">
                        <strong class="mr-auto"><?php if($_SESSION['type_message']) { echo 'Correcto'; } else { echo 'Error'; } ?></strong>
                        
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body" style="font-size: 20px; text-align: justify;">

                       <?php  echo $_SESSION['text_message']; ?>
                    </div>
                </div>
            <?php } ?>

            <?php /*if(isset($this->message['type_message']) && isset($this->message['text_message'])) { ?>
                <div class="toast toast-def" id="toast" style="position: absolute; margin: auto; top: 40vh; left: 43vw;" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
            <div class="toast-header" style="<?php if($this->message['type_message']) { ?> background-color: rgba(189, 253, 157, 0.85); <?php } else { ?> background-color: rgba(255, 89, 89, 0.85); <?php } ?> color: #444444;">
                        <strong class="mr-auto"><?php if($this->message['type_message']) { echo 'Correcto'; } else { echo 'Error'; } ?></strong>
                        
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">

                       <?php  echo $this->message['text_message']; ?>
                    </div>
                </div>
            <?php } */ ?>
            

            <!--   Core   -->
 
            <script src="../Views/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>


            <!--   Optional JS   -->
            <script src="../Views/js/plugins/chart.js/dist/Chart.min.js"></script>
            <script src="../Views/js/plugins/chart.js/dist/Chart.extension.js"></script>
            <script type="text/javascript" src="../Views/js/bootstrap-clockpicker.min.js"></script>
            <script type="text/javascript" src="../Views/js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
            <script type="text/javascript" src="../Views/js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
            <script type="text/javascript" src="../Views/js/select.js"></script>


            
            <script src="../Views/js/main.js"></script>
            <noscript>
                <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=111649226022273&ev=PageView&noscript=1" />
            </noscript>
            
            <!--   Argon JS   -->
            <script src="../Views/js/argon-dashboard.min.js"></script>
            <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
            


            <div id="chart-tooltip" class="popover bs-popover-top" role="tooltip" style="top: 405.779px; left: 969.103px; display: none; z-index: 100;"><div class="arrow"></div><h3 class="popover-header text-center">Oct</h3><div class="popover-body d-flex align-items-center justify-content-center"><span class="badge badge-dot"><i class="bg-primary"></i></span><span class="popover-body-value">$40k</span></div></div></body>
            </html>
        <?php 
    }
}
?>