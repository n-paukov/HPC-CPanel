<?php defined('SC_PANEL') or die; ?>
<div class="form-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="<?php echo innoUrl($currentRouteSection); ?>" method="post" class="form-example-wrap" enctype="multipart/form-data">
                    <div class="cmp-tb-hd">
                        <h2>Добавление задачи в очередь</h2>
                    </div>
                    <div>
                        <?php innoFormFieldRow('task[name]', 'Название задачи', 'Название задачи', true, $formData['name']); ?>
                        <?php innoFormFieldRow('task[source]', 'Исходный код на языке Си', 'Исходный код', true, $formData['source'], 'file'); ?>
                        <?php innoFormFieldRow('task[compilerOptions]', 'Дополнительные ключи компиляции (gcc)', 'Ключи компиляции',
                            false, $formData['compilerOptions'], 'textarea'); ?>

                        <?php innoFormFieldRow('task[memoryLimit]', 'Максимальный объем оперативной памяти (ГБ)', '128',
                            false, $formData['memoryLimit']); ?>

                        <?php innoFormFieldRow('task[maxCores]', 'Максимальное количество процессорных ядер', '2',
                            false, $formData['maxCores']); ?>

                        <?php innoFormFieldRow('task[timeLimit]', 'Максимальная длительность выполнения (в секундах)', '3600',
                            false, $formData['timeLimit']); ?>

                        <?php innoFormFieldRow('task[startTime]', 'Время запуска (укажите для отложенного запуска)', 'dd.mm.yyyy hh:ii:ss',
                            false, $formData['startTime'], 'text', '99.99.9999 99:99:99'); ?>
                    </div>
                    <div class=" mg-t-15">
                        <button type="submit" class="btn btn-success notika-btn-success">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>