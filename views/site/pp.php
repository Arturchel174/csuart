<?php
use yii\helpers\Url;
echo '<div class="col-lg-3"><table class="table table-bordered table-striped">
<thead>
  <tr>
    <th>Предметы</th>
  </tr>
</thead>';
foreach ($subject as $key => $value)
  {
    echo "<tr>";
    $url = Url::toRoute(['site/pp', 'ids' => $key]);
  echo "<td>".'<a href="'.$url.'">'.$value.'</a><br>'."</td></tr>";
  }
  echo '</table>
  </div>';
?>


<div class="col-lg-5" style="position: relative;float:left; margin-left:10px;">
<h1 style="margin-top:0px;"><?= $subject1->sub ?></h1>
<h3><?= 'Общая посещаемость - </br>'.$subject1->totalSubject ?></h3>
</div>
