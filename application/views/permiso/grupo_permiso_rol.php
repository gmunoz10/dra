<?php 
    foreach ($grupos_permiso as $key => $grupo_permiso) { 
        if ($key%2==0){
            echo '<div class="col-lg-12">';
        }
?>
<div class="box-bold col-md-5 no-padding" style="margin: 10px; background: transparent;">
    <div class="table-responsive">
        <table class="table table-bordered table-condensed table-permiso no-margin">
            <thead>
                <tr>
                    <th colspan="2"><?= $grupo_permiso->desc_gpr ?></th>
                </tr>
            </thead>
            <tbody data-gpr="<?= $grupo_permiso->codi_gpr ?>">
                <?php foreach ($grupo_permiso->permisos as $permiso) { ?>
                    <tr data-per="<?= $permiso["codi_per"] ?>" data-pro="<?= $permiso["codi_pro"] ?>">
                        <td>
                            <?= $permiso["desc_per"] ?>
                        </td>
                        <td>
                            <input type="checkbox" <?= ($permiso["valo_pro"] == "1") ? "checked" : "" ?> <?= ($codi_rol == "1" || !check_permission(MODIFICAR_PERMISO_ROL)) ? "disabled" : "" ?> data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on='<i class="fa fa-check" aria-hidden="true"></i>' data-off='<i class="fa fa-ban" aria-hidden="true"></i>' class="check_permiso">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php if($codi_rol != "1" && check_permission(MODIFICAR_PERMISO_ROL)) { ?>
        <button class="btn btn-primary pull-right btn_save_permiso" style="border-radius: 0px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
    <?php } ?>
</div>

<?php 
        if ($key%2!=0 || $key == count($grupos_permiso)){
            echo '</div>';
        }
    } 
?>