<title>Заметки | <?=$category[$ctg]?></title>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default opacity">
            <div class="panel-heading">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="list-group-horizontal">
                            <?php foreach($category as $key => $cat): ?>
                                    <a href="notice?cat=<?=$key?>" class="list-group-item <?php if($ctg == $key) echo "active"?>"><?=$cat?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <table class="table" style="margin: 0; text-align: center;">
                            <tr>
                                <td class="danger">Просроченные заметки</td>
                                <td class="success">Важные заметки</td>
                                <td class="warning">Не важные заметки</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-2">
                        <div class="btn-group" style="float: right;">
                            <a href="/notice/add" class="btn btn-default">Новая заметка</a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel-body">
                <?php if(!empty($_SESSION['success']))showSuccess($_SESSION['success']); ?>
                <div class="table-responsive">
                    <table class="table table-hover">

                        <thead>
                            <?php if(!empty($notices)): ?>
                                <tr class="info table-head">
                                    <td width="10%">Заметка</td>
                                    <td width="50%">Описание</td>
                                    <td width="5%">Дата</td>
                                    <td width="2%">Время</td>
                                    <td width="2%">Статус</td>
                                    <td width="2%"></td>
                                </tr>
                            <?php else: ?>
                                <tr class="info table-head">
                                    <td>Записей в данной категории нет</td>
                                </tr>
                            <?php endif; ?>
                        </thead>

                        <tbody>
                            <?php if(!empty($notices)): ?>
                                <?php foreach($notices as $note): ?>
                                    <tr>
                                        <?php  if(comparisonDate($note->date)):?>
                                            <td><a href="/notice/view?id=<?=$note->id?>"><?=$note->header?></a></td>
                                        <?php  else: ?>
                                            <td class="danger"><a href="/notice/view?id=<?=$note->id?>"><?=$note->header?></a></td>
                                        <?php  endif;?>

                                        <td><?=$note->description?></td>
                                        <td><?=getDateFromTimestamp($note->date)?></td>
                                        <td><?=getTimeFromTimestamp($note->date)?></td>

                                        <?php if($note->importance == 1): ?>
                                            <td class="success"></td>
                                        <?php else: ?>
                                            <td class="warning"></td>
                                        <?php endif; ?>

                                        <td class="title-panel-imp-note" width="5%">
                                            <a href="/notice/edit?id=<?=$note->id?>" title="Редактировать заметку '<?=$note->header?>'"><span class="glyphicon glyphicon-pencil"></a></span>
                                            <a href="/notice/delete?id=<?=$note->id?>&cat=<?=$note->category?>" title="Удалить заметку '<?=$note->header?>'"><span class="glyphicon glyphicon-remove"></a></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                    </table>

                    <?php if(!empty($notices) && $count_page>1): ?>
                    <ul class="pagination">
                        <li><a href="notice?cat=<?=$ctg?>&p=1">&laquo;</a></li>
                        <?php for($i = 1; $i<=$count_page; $i++): ?>
                        <li <?php if($i == $p || empty($p)) echo 'class="active"' ?>><a href="notice?cat=<?=$ctg?>&p=<?=$i?>"><?=$i?></a></li>
                        <?php endfor; ?>
                        <li><a href="notice?cat=<?=$ctg?>&p=<?=$count_page?>">&raquo;</a></li>
                    </ul>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>