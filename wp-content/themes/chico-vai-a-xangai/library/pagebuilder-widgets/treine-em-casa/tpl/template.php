<TreineEmCasa title="<?= $instance['title'] ?>" subtitle="<?= $instance['subtitle'] ?>"  :selected_workouts="[<?= implode(', ', $instance['workouts']) ?>]">
<div style="background:black; padding: 10px; color: white">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h4 style="color: orange"><?= $instance['title'] ?></h4>
            </div>
            <div class="col-md-3">
                <h5>Exemplo de treino 1</h5>
                <p>Descrição de treino</p>
            </div>
            <div class="col-md-3">
                <h5>Exemplo de treino 2</h5>
                <p>Descrição de treino</p>
            </div>
        </div>
    </div>
</div>
</TreineEmCasa >