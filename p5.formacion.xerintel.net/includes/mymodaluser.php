<div class="modal fade" id="myModalUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×</button>
                        <h4 class="modal-title" id="myModalLabel">
                            Estos son tus datos -</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" style="border-right: 1px dotted #C2C2C2;padding-right: 30px;">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#dataUser" data-toggle="tab">Mis datos</a></li>
                                    <li><a href="#dataBill" data-toggle="tab">Facturacion</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="tab-pane active" id="dataUser">
                                        <form id="idformregister" role="form" class="form-horizontal" name="formupdateuser" method="POST" action="">
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    Name</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <input id="name" type="text" class="form-control" name="name" placeholder="<?php echo $_SESSION['name']; ?>" />
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="lastname" placeholder="<?php echo $_SESSION['lastname']; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    Email</label>
                                                <div class="col-sm-10">
                                                    <input id="email" type="email" class="form-control" name="email" placeholder="<?php echo $_SESSION['email']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile" class="col-sm-2 control-label">
                                                    Usuario</label>
                                                <div class="col-sm-10">
                                                    <input id="username" type="text" class="form-control" name="username" placeholder="<?php echo $_SESSION['username']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" name="password" placeholder="Password" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-10">
                                                    <button name="formupdateuser" type="submit" class="btn btn-primary btn-sm">
                                                        Save & Continue</button>
                                                    <button type="button" class="btn btn-default btn-sm">
                                                        Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="dataBill">
                                        <form id="idformregister" role="form" class="form-horizontal" name="formupdatebill" method="POST" action="">
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    Name</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option>Mr.</option>
                                                                <option>Ms.</option>
                                                                <option>Mrs.</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input id="name" type="text" class="form-control" name="name" placeholder="Name" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="lastname" placeholder="Apellidos" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    Email</label>
                                                <div class="col-sm-10">
                                                    <input id="email" type="email" class="form-control" name="email" placeholder="Email" onblur="check(this.value)"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile" class="col-sm-2 control-label">
                                                    Usuario</label>
                                                <div class="col-sm-10">
                                                    <input id="username" type="text" class="form-control" name="username" placeholder="Usuario" onblur="check02(this.value)"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" name="password" placeholder="Password" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-10">
                                                    <button name="formupdatebill" type="submit" class="btn btn-primary btn-sm">
                                                        Save & Continue</button>
                                                    <button type="button" class="btn btn-default btn-sm">
                                                        Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
