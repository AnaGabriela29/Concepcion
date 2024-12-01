<?php
headerAdmin($data);

?>
<script src="<?=$data['librarie']?>"></script>

<style>
.box-qr{
    max-width: 30rem;
    max-height: 30rem;
    position: relative;
}
/* #html5-qrcode-button-camera-stop, #html5-qrcode-button-camera-start{
    border-radius: 0.5rem;
    background-color: rgb(20, 124, 174);
    color: white;
} */
.txtidentificacion{
    max-width: 15rem;
}
.state-asistencia{
    max-width: 10rem;
}
</style>

<section class="row">
    <div class="col-12">
        <p>Registro de asistencia al Colegio UNIMAT</p>
    </div>   
</section>
<section class="row">
    <div class="box-qr col-12 col-lg-6">
            <div class="reader rounded" id="reader"></div>
            <div class="result" id="result"></div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="col-12 my-4 asistencia">
            <label for="estadoAsistencia" class="color-sky-blue fw-bold">Estado de la asistencia</label>
            <select class="form-select state-asistencia" name="estadoAsistencia" id="estadoAsistencia">
                <option value="Puntual">Puntual</option>
                <option value="Tardanza">Tardanza</option>
            </select>
        </div>

        <p class="color-sky-blue fw-bold">Registro Manual</p>
        <form action="" class="formAsistencia " id="formAsistencia" name="formAsistencia">
            <div class="input-group bg-color-gray p-3 rounded">
                <label for="txtidentificacion">Numero de DNI</label>
                <input type="number" class="txtidentificacion  ms-2 form-control rounded" id="txtidentificacion" name="txtidentificacion" aria-label=""  placeholder="Digite numero de dni">
            </div>
            <div class="my-2">
                <button id="btnActionForm" class="btn bg-color-sky-blue shadow-box" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
            </div>
            <div>

            </div>
        </form>
    </div>
</section>
<section class="row">
    
</section>



<?php
footerAdmin($data);
?>