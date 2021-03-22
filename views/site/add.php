<?php

if($response){
    echo json_encode($response);
    return;
}

/* @var $this yii\web\View */

$this->title = 'Добавить заказ';

?>

<div class="container d-flex justify-content-center">
    <div class="card col-lg-8">
      <h5 class="card-header">Добавить заказ</h5>
      <div class="card-body">
        <form id="addOrder">
        <div class="row d-flex justify-content-center text-center">
          <div class="col-lg-10">
            <select class="form-select" name="customer">
              <option selected value="">Укажите заказчика</option>
              <?php foreach ($customer as $customers) { ?>
              <option value="<?=$customers->Fullname;?>"><?=$customers->Fullname;?></option>
              <?php } ?>
            </select>
          </div>
          <div class='col-lg-5'><label for="date_from">Дата начала работ</label><input type="date" class="form-control" id="date_from" name="date_from"></div>
          <div class='col-lg-5'><label for="date_to">Дата окончания работ</label><input type="date" class="form-control" id="date_to" name="date_to"></div>


          <div class='col-lg-10' style="margin: 10px 0 10px 0"><textarea class="form-control" placeholder="Укажите список требуемых работ" name="listWorks"></textarea></div>
          <div class='col-lg-10'><input type="text" class="form-control" placeholder="Стоимость" name="price"></div>
          <input type="submit" value="Добавить заказ" class="btn bg-light border col-lg-5" style="margin-top: 10px;">
          <div class="text-danger" id="errors"></div>
          <div class="text-success" id="success"></div>
        </div>
        </form>
      </div>
    </div>
    <br>
</div>
