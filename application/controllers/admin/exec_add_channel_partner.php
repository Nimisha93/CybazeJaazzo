<?php include('header.php'); ?>
<body>
<div class="wrapper">

    <?php include('nav.php'); ?>

    <div class="content">
        <div class="container-fluid">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title"> Add Channel Partner </h4>

                    </div>
                    <div class="card-content">

                        <form method="#" action="#">

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Module</label>
                                    <select class="form-control">
                                        <option></option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                        <option>Option 4</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">

                                    <select multiple="multiple" placeholder="Channel Partner Sub Types" onchange="console.log($(this).children
                                    (':selected')
                                    .length)" class="testSelAll form-control">
                                        <option  value="volvo">Volvo</option>
                                        <option value="saab">Saab</option>
                                        <option disabled="disabled" value="mercedes">Mercedes</option>
                                        <option value="audi">Audi</option>
                                        <option  value="bmw">BMW</option>
                                        <option value="porsche">Porche</option>
                                        <option value="ferrari">Ferrari</option>
                                        <option value="mitsubishi">Mitsubishi</option>


                                    </select>

                                </div>
                            </div>


                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Contact Person</label>
                                    <input type="text" class="form-control">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Contact Number</label>
                                    <input type="text" class="form-control">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Email</label>
                                    <input type="text" class="form-control">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Country</label>
                                    <select class="form-control">
                                        <option></option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                        <option>Option 4</option>
                                    </select>

                                </div>
                            </div>


                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">State</label>
                                    <select class="form-control">
                                        <option></option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                        <option>Option 4</option>
                                    </select>

                                </div>
                            </div>


                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Town</label>
                                    <select class="form-control">
                                        <option></option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                        <option>Option 4</option>
                                    </select>

                                </div>
                            </div>




                            <div class="col-md-12 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Address</label>
                                    <textarea type="text" class="form-control"></textarea>
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>


                            <div class="col-md-3 col-sm-6">

                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                                    <span class="btn btn-rose btn-round btn-file crsor">
                                                        <span class="fileinput-new crsor">Select Profile image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" class="crsor" name="">
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3 col-sm-6">

                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                                    <span class="btn btn-rose btn-round btn-file crsor">
                                                        <span class="fileinput-new crsor">Select Brand image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" class="crsor" name="">
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Latitude*</label>
                                    <input type="text" class="form-control">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Longitude*</label>
                                    <input type="text" class="form-control" required>
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d11692
                                .665410257658!2d75.70305739619836!3d11
                                .439862032765266!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13
                                .1!5e0!3m2!1sen!2sus!4v1516172097571" width="100%" height="350" frameborder="0"
                                        style="border:0" allowfullscreen></iframe>
                                </div>


                            <div class="col-md-12">
                                <button type="submit" class="btn btn-fill btn-rose">Submit</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>




        </div>

        <?php include('footer.php'); ?>

        <link href="assets/css/sumoselect.css" rel="stylesheet">
        <script src="assets/js/sumoslct.js"></script>
</body>

</html>