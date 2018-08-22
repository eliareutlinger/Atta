<?php

    include("../../include/session.php");
    include("../../include/database.php");
    include("../../include/alerts.php");

    if(!$session_loggedin){
        echo '<script type="text/javascript">parent.window.location.reload();</script>';
        exit();
    }

?>

<section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
    <div class="my-auto">

        <h3 class="mb-0">Entry Presets</h3>
        <p>
            <?php
            $gdInfoArray = gd_info();
$version = $gdInfoArray["GD Version"];
echo "Your GD version is:".$version;
echo "<hr />";
foreach ($gdInfoArray as $key => $value) {
echo "$key | $value<br />";
}
            ?>
        </p>
        <div class="col-lg-12">
            <div class="row">

                <div class="row">
                    <div class="col-6">
                        <button data-toggle="modal" data-target="#addUserModal" style="padding-top: 4px; padding-bottom: 5px;" class="btn btn-block btn-lg btn-primary">
                            <span class="fa fa-plus" aria-hidden="true"></span> Add
                        </button>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <i class="fa fa-search" style="position: absolute; padding: 10px; right: 15px;" aria-hidden="true"></i>
                            <input type="text" class="form-control" id="searchInput" placeholder="">
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addUserModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form action="modul/objects/call/addPreset.php" name="addNewPresetForm" id="addNewPresetForm" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Preset</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row" id="addUserForm">
                                        <div class="col-lg-6">
                                            <label for="usrFormBkey">Title</label>
                                            <input type="text" class="form-control addUserInput" id="f_new_title" name="f_new_title" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="usrFormGroup">Calories</label>
                                            <input type="text" class="form-control addUserInput" id="f_new_calories" name="f_new_calories" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="usrFormGroup">Amount</label>
                                            <input type="text" class="form-control addUserInput" id="f_new_amount" name="f_new_amount" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="usrFormGroup">Image</label>
                                            <input type="file" class="form-control addUserInput" id="f_new_image" name="f_new_image">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" id="f_submit" value="Add">
                                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12" id="searchList">

                    <?php

                        $sql = "SELECT * FROM `tb_user_object` WHERE tb_user_ID = $session_userid ORDER BY ID DESC;";
                        $res = $mysqli->query($sql);
                        if (isset($res) && $res->num_rows > 0) {
                            while($row = $res->fetch_assoc()) {

                                if(!$row['img_path']){
                                    $row['img_path'] = "default.png";
                                }

                                echo '
                                <div class="searchRow highlighter row card" style="padding-top:10px; min-width: 70vw; padding-left: 10px; padding-right: 15px; margin-bottom: 10px;">

                                    <div class="row objectHeader searchFor" objectID="'.$row['ID'].'" style="height: 30px;">
                                        <div class="col-lg-6" style="cursor: pointer;">
                                            <p id=""><b>'.$row['title'].'</b></p>
                                        </div>
                                        <div class="col-lg-6 text-right" style="cursor: pointer;">
                                            '.$row['calories'].' Clories | Default Amount: '.$row['amount'].'
                                        </div>
                                    </div>

                                    <div class="row objectContent" objectID="'.$row['ID'].'" style="padding: 15px; display:none;">

                                        <!-- CONTENTS -->
                                        <div class="col-lg-4">
                                            <div class="col-lg-12">
                                                Title <input type="text" class="form-control" value="'.$row['title'].'">
                                            </div>
                                            <div class="col-lg-12">
                                                Calories <input type="number" class="form-control" value="'.$row['calories'].'">
                                            </div>
                                            <div class="col-lg-12">
                                                Default Amount <input type="number" class="form-control" value="'.$row['amount'].'">
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            Image
                                            <div class="row">
                                                <div class="col-lg-4 my-auto">
                                                    <img src="img/calObjects/'.$row['img_path'].'" class="img-fluid" alt="objectImg" />
                                                </div>
                                                <div class="col-lg-8 my-auto">
                                                    <div class="col-lg-4">
                                                        Change <input type="file" class="form-control" id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SAVE AND DELETE BUTTONS -->
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-lg-6">
                                            <button class="btn btn-block btn-lg btn-success fSave"><span class="fa fa-floppy-o" aria-hidden="true"></span> Save</button>
                                            <br />
                                        </div>
                                        <div class="col-lg-6">
                                            <button class="btn btn-block btn-lg btn-danger fDelete"><span class="fa fa-trash-o" aria-hidden="true"></span> Delete</button>
                                        </div>

                                        <br>
                                    </div>

                                </div>
                                ';

                            }
                        }

                    ?>


                </div>
            </div>
        </div>

    </div>
</section>
<script type="text/javascript" src="modul/objects/objects.min.js"></script>
