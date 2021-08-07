<?php
include "class/TipoProductoClass.php";

$objTipoProducto = new TipoProductoClass();

$listaCategorias = $objTipoProducto->getTipoProductos();
?>
<div class="row px-0 mx-0">
    <div class="col mx-0 px-0" style="background-color: #c1c1c152">
        <!-- Slider main container -->
        <div class="swiper-container ">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper wrapper-categorias">


                <?php foreach ($listaCategorias as $categoria) { ?>
                    <div class="swiper-slide">
                        <div
                            <?php
                            //si es sushi lo manda a otra pagina
                            if ($categoria['idTipoProducto'] == 31) { ?>
                                onclick='window.location = "senshi-sushi.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"'
                            <?php } elseif ($categoria['idTipoProducto'] == 27){
                                ?>
                                onclick='window.location = "senshi-paquetes.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"'
                                <?php
                            }elseif ($categoria['idTipoProducto'] == 29){
                                ?>
                                onclick='window.location = "senshi-gift-cards.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"'
                                <?php
                            }elseif ($categoria['idTipoProducto'] == 25){
                                ?>
                                onclick='window.location = "senshi-makis.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"'
                                <?php
                            }
                            elseif ($categoria['idTipoProducto'] == 33){
                                ?>
                                onclick='window.location = "senshi-tacos.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"'
                                <?php
                            }
                            else { ?>
                                onclick='window.location = "platos.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"'
                            <?php } ?>
                            class="card mr-auto ml-auto card-categoria">

                            <div class="card-body">
                                <img class="img-categoria" src="img/carta/categorias/<?php echo $categoria['imageUrl'] ?>"
                                     alt="<?php echo $categoria['nombre'] ?> - Senshi Sushi Bar">
                            </div>
                            <div style="margin-top: -120px;z-index: 1">
                                <h3 onclick='window.location = "platos.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"' class="text-white text-center font-weight-bolder"><?php echo $categoria['nombre'] ?></h3>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>
