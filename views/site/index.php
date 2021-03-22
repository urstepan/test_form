<?php

if($response){
    echo json_encode($response);
    return;
}
/* @var $this yii\web\View */

$this->title = 'Главная';

?>

<div class="container justify-content-center">
    <div class="card col lg-10">
      <h5 class="card-header">Фильтр </h5>
      <div class="card-body">
        <form id="formFilter">
        <div class="row">
          <div class='col-lg-3'><input type="date" class="form-control" placeholder="Дата" name="filterDate"></div>
          <div class='col-lg-3'><input type="text" class="form-control" placeholder="Стоимость" name="filterPrice"></div>
          <input type="submit" value="Применить" class="btn bg-light border col-lg-2" style="margin-right: 10px;">
          </form>
          <a class="btn bg-light border col-lg-2" onclick="cleanFilter()">Сбросить</a>
        </div>
      </div>
    </div>
    <br>
    <a href="/site/add"><button class="btn bg-light border col-lg-2">Добавить заказ</button></a>

    <table class="table table-bordered text-center" style="margin-top: 15px;" id="tableOrder">
      <thead class="bg-light">
        <tr>
          <th scope="col">ФИО</th>
          <th scope="col">Работы</th>
          <th scope="col">Дата начала</th>
          <th scope="col">Дата окончания</th>
          <th scope="col">Стоимость</th>
          <th scope="col">Исполнитель</th>
          <th scope="col">Исполнитель</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($order as $orders) { 
            $colorTable = "bg-transparent";
            if(strtotime($orders->Date_from) < time() && !$orders->contractors->user->Fullname){ $colorTable = "bg-danger"; }
        ?>
        <tr id="class<?=$orders->ID;?>" class="filtTr <?=$colorTable;?>">   
          <th scope="row"><a href="/site/view/?id=<?=$orders->ID;?>"><?=$orders->user->Fullname;?></a></th>
          <td><?= $orders->Work_list; ?></td>
          <td class="fDate"><?= $orders->Date_from; ?></td>
          <td><?= $orders->Date_to; ?></td>
          <td class="fPrice"><?= $orders->Price; ?></td>
          <td id="contrName<?=$orders->ID;?>"><?=$orders->contractors->user->Fullname;?></td>
          <td><button class="btn bg-light border" data-toggle="modal" data-target="#contractor_<?=$orders->ID;?>">Назначить исполнителя</button></td>
        </tr>
        <?php }  ?>
          
      </tbody>
    </table>
</div>
<?php foreach ($order as $orders) { ?>
<div class="modal" tabindex="-1" id="contractor_<?=$orders->ID;?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Назначить исполнителя</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="contractorForm">
            <select class="form-select" name="contractor">
                <option selected value="">Список исполнителей</option>
                <?php foreach ($contractor as $contractors) { ?>
                <option value="<?=$contractors->Fullname;?>"><?=$contractors->Fullname;?></option>
                <?php } ?>
            </select>
            <br>
            <?php 
                $typeTextarea = "";
                $typeChange = 1;

                if(!$orders->contractors->user->Fullname){
                    $typeTextarea = "readonly";
                    $typeChange = 0;
                }
            ?>
            <textarea name="reason" class="form-control textarea<?=$orders->ID;?>" placeholder="Причина смены исполнителя" <?=$typeTextarea; ?>></textarea>
            <input type="hidden" name="orderID" value="<?=$orders->ID;?>">
            <input type="hidden" name="typeChange" value="<?=$typeChange;?>">
            <div class="text-danger" id="errors<?=$orders->ID;?>"></div>
        
      </div>
      <div class="modal-footer justify-content-center">
        <input type="submit" class="btn btn-light border col-lg-5" value="Назначить">
        <button type="button" class="btn btn-light border col-lg-5" data-dismiss="modal">Отменить</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php } ?>