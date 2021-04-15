<?php
include_once "libs/libUtils.php";
include_once "libs/libSQL.pdo.php";
include_once "libs/libSecurisation.php";
include_once "libs/modele.php";
include_once "libs/upload_photo.php";


$connected_user=valider('id_user','SESSION');
$list_id_conversation = get_conversations_user( $connected_user);   
//var_dump($list_id_conversation);
//var_dump($connected_user);
?>




<style>
    body {

        min-height: 100vh;
    }

    ::-webkit-scrollbar {
        width: 5px;
    }

    ::-webkit-scrollbar-track {
        width: 5px;
        background: #f5f5f5;
    }

    ::-webkit-scrollbar-thumb {
        width: 1em;
        background-color: #ddd;
        outline: 1px solid slategrey;
        border-radius: 1rem;
    }

    .text-small {
        font-size: 0.9rem;
        color: #35516E;
    }

    .messages-box,
    .chat-box {
        height: 510px;
        overflow-y: scroll;
    }

    .rounded-lg {
        border-radius: 15px;
    }

    input::placeholder {
        font-size: 0.9rem;
        color: #999;
    }
    h6{
        color: #35516E;
    }
    .text-small-light{
        font-size: 0.9rem;
        color: #FFF7ED;
    }

</style>
</head>
<body>
<div class="container py-5 px-4">
    <!-- For demo purpose-->
    <header class="text-center">
        <h1 class="display-4" style="color: #fdedcf; margin-bottom: 50px;">Conversations</h1>
    </header>

    <div class="row rounded-lg overflow-hidden shadow" style="background-color: white">
        <!-- Users box-->
        <div class="col-5 px-0">
            <div class="bg-white">

                <div class="bg-gray px-4 py-2 bg-light">
                    <p class="h5 mb-0 py-1" style="color: #153455">MES DISCUSSIONS</p>
                </div>

                <div class="messages-box" >
                    <div id ='message_list' class="list-group rounded-0" >

                    <?php foreach ($list_id_conversation as $id_conv_array) {
                        $id_conv = (int) $id_conv_array['id'];
                        //var_dump($id_conv);
                        $last_msg_info = get_last_msg_info($id_conv);
                        //var_dump($last_msg_info);
                        if ($last_msg_info['auteur'] == $connected_user) {
                        $destinataire_id= (int) $last_msg_info['destinataire'] ;
                        } else {
                        $destinataire_id = (int) $last_msg_info['auteur'];
                        }
                        //var_dump($destinataire_id);
                        $destinataire_info = find_user_name($destinataire_id);
                        //var_dump($destinataire_info);
                        display_conv($last_msg_info,$destinataire_info[0],$id_conv,$destinataire_id,$connected_user);
                    }  
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Chat Box-->
        <div class="col-7 px-0">
            <div class="px-4 py-5 chat-box" style="background-color: #FFF7ED">
                <!-- Sender Message-->
                <div class="media w-50 mb-3"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                    <div class="media-body ml-3">
                        <div class="bg-light rounded py-2 px-3 mb-2">
                            <p class="text-small mb-0 ">Message échangé numéro 1</p>
                        </div>
                        <p class="small text-muted">12:00 PM | Aug 13</p>
                    </div>
                </div>

                <!-- Reciever Message-->
                <div class="media w-50 ml-auto mb-3">
                    <div class="media-body">
                        <div class=" rounded py-2 px-3 mb-2" style="background-color: #35516E">
                            <p class="text-small-light mb-0">Message échangé numéro 2</p>
                        </div>
                        <p class="small text-muted">12:00 PM | Aug 13</p>
                    </div>
                </div>

                <!-- Sender Message-->
                <div class="media w-50 mb-3"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                    <div class="media-body ml-3">
                        <div class="bg-light rounded py-2 px-3 mb-2">
                            <p class="text-small mb-0">Message échangé numéro 3</p>
                        </div>
                        <p class="small text-muted">12:00 PM | Aug 13</p>
                    </div>
                </div>

                <!-- Reciever Message-->
                <div class="media w-50 ml-auto mb-3">
                    <div class="media-body">
                        <div class=" rounded py-2 px-3 mb-2" style="background-color: #35516E">
                            <p class="text-small-light mb-0">Message échangé numéro 4</p>
                        </div>
                        <p class="small text-muted">12:00 PM | Aug 13</p>
                    </div>
                </div>

                <!-- Sender Message-->
                <div class="media w-50 mb-3"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle">
                    <div class="media-body ml-3">
                        <div class="bg-light rounded py-2 px-3 mb-2">
                            <p class="text-small mb-0">Message échangé numéro 5</p>
                        </div>
                        <p class="small text-muted">12:00 PM | Aug 13</p>
                    </div>
                </div>

                <!-- Reciever Message-->
                <div class="media w-50 ml-auto mb-3">
                    <div class="media-body">
                        <div class=" rounded py-2 px-3 mb-2" style="background-color: #35516E">
                            <p class="text-small-light mb-0 ">Message échangé numéro 6</p>
                        </div>
                        <p class="small text-muted">12:00 PM | Aug 13</p>
                    </div>
                </div>

            </div>

            <!-- Typing area -->
            <form action="#" class="bg-light">
                <div class="input-group">
                    <input type="text" placeholder="Type a message" aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light">
                    <div class="input-group-append">
                        <button id="button-addon2" type="submit" class="btn btn-link"> <i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    function start_function(){
        console.log('Le document est chargé');
        // appel api pour récupérer la liste des conversations

        // mettre les conversations aux bons endroits avec les données de l'api 


        
    }
    $(document).ready(start_function);




</script>
</body>
</html>
