<?php 
$this->title = 'Просмотр заказов';

?>


<div class="container justify-content-center">
    <table class="table table-bordered text-center" style="margin-top: 15px;" id="tableOrder">
      <thead class="bg-light">
        <tr>
          <th scope="col">ФИО</th>
          <th scope="col">Работы</th>
          <th scope="col">Дата начала</th>
          <th scope="col">Дата окончания</th>
          <th scope="col">Стоимость</th>
          <th scope="col">Исполнитель</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($order as $orders) { 

        ?>
        <tr id="class<?=$orders->ID;?>" class="filtTr">   
          <th scope="row"><?=$orders->user->Fullname;?></th>
          <td><?= $orders->Work_list; ?></td>
          <td class="fDate"><?= $orders->Date_from; ?></td>
          <td><?= $orders->Date_to; ?></td>
          <td class="fPrice"><?= $orders->Price; ?></td>
          <td id="contrName<?=$orders->ID;?>"><?=$orders->contractors->user->Fullname;?></td>
        </tr>
        <?php }  ?>
          
      </tbody>
    </table>
    <?php foreach ($contractor as $contractors) { ?>
    <div class="alert alert-secondary" role="alert">
    	<b>Смена исполнителя на:</b> <?=$contractors->user->Fullname;?><br>
    	<b>Причина:</b> <?=$contractors->Reason;?><br>
    	<i class="text-muted"><?=$contractors->Date_set;?></i>
    </div>
    <?php } ?> 
</div>