 <div class="container-fluid">
     <div class="card shadow">
         <div class="card-header py-3 d-flex justify-content-between">

             <div>
                 <p class="text-primary m-0 fw-bold">Produits

                 </p>
             </div>
             <div><a href="table.php?D_All=yes&see=product" class="btn btn-warning ">Voir tous</a></div>

         </div>

         <div class="card-body">
             <div class="row">
                 <div class="col-md-6 text-nowrap">
                     <form action="table.php?forProd=yes&see=product" method="get">
                         <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                             <label class="form-label">Voir&nbsp;<select class="d-inline-block form-select form-select-sm" name="filter">
                                     <?php
                                        if (isset($products) && $products != null) {
                                            if (count($products) > 20) {
                                                echo '<option value="all" selected="">All</option>
                                                <!--choisir lui meme le nombre-->
                                                <option value="10">10</option>
                                                <option value="15">25</option>';
                                            } else if (count($products) > 10 && count($products) < 20) {
                                                echo '<option value="all" selected="">All</option>';
                                                echo '<option value="5">5</option>';
                                            } else {
                                                echo '<option value="all" selected="" disabled>All</option>';
                                            }
                                        } else if (isset($products) && $products == null) {
                                            echo '<option value="0" selected="" >0</option>';
                                        }
                                        ?>

                                 </select>&nbsp;</label>
                         </div>

                 </div>


                 </form>

                 <div class="col-md-6">

                     <form action="table.php?forProd=yes&see=product" method="post">
                         <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Rechercher un tout..." name="search"></label></div>
                     </form>
                 </div>
             </div>
             <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                 <table class="table table-bordered table-hover table-info table-responsive table-striped
                   my-0" id="dataTable">
                     <thead>
                         <tr>
                             <th><i class="fas fa-photo"></i>Photo</th>
                             <th><i class="fas fa-user-alt"></i>Nom</th>
                             <th><i class="fas fa-audio-description"></i>Description</th>
                             <th><i class="fas fa-product-hunt"></i> Gamme</th>
                             <th><i class="fas fa-link"></i>Détails affectation</th>
                             <th><i class="fas fa-trash-alt"></i>Supprimer</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            if (isset($products) && !empty($products)) {
                                foreach ($products as $prod) {
                                    echo
                                    "<tr>
                                                <td><img class='rounded-circle me-2' width='45' height='45' src='../assets/images/product/" . $prod['photo_produit'] . "' onclick='showImage(this)'></td>
                                            <td class='text-upper'> " . $prod['nom_produit'] . "</td>
                                            <td>" . $prod['description'] . "</td>
                                            <td>" . $prod['categorie'] . "</td>
                                            <td class='gaper'><a class='btn btn-info btn-hover-light animated--grow-in' href='infoProd.php?prod=" .
                                    $prod['id_produit'] . "&nom=" . $prod['nom_produit'] . "'><i class='fas fa-edit'></i>voir</a></td>
                                            <td></i><a class='btn btn-danger' href='deleter.php?id=" .
                                    $prod['id_produit'] . "&action=produit'><i class='fas fa-trash '>Supprimer</a></td>
                                            
                                            
                                                </tr>";
                                }
                                if (count($products) > 7) {
                                    echo '<tfoot>
                                            <tr>
                                               <th><i class="fas fa-images"></i>Photo</th>
                                                 <th><i class="fas fa-user-alt"></i>Nom</th>
                                                 <th><i class="fas fa-audio-description"></i>Description</th>
                                                 <th><i class="fas fa-images"></i> Gamme</th>
                                                 <th><i class="fas fa-link"></i>Détails affectation</th>
                                                 <th><i class="fas fa-trash-alt"></i>Supprimer</th>
                                            </tr>
                                        </tfoot>';
                                }
                            } else {
                                echo "<tr>
                                            <td colspan='8'><div class='alert alert-danger'>Aucun produit trouver!</div>
                                             
                                            </td>
                                        </tr>";
                            }
                            ?>


                 </table>
             </div>
             <?php if (isset($products) && count($products) > 10) {
                ?>
                 <div class="row">
                     <div class="col-md-6 align-self-center">
                         <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                             Showing 1 to 10 of <?php
                             if (count($products) > 10)
                                                    echo
                                                    count($products);

                                                ?></p>
                     </div>
                     <div class="col-md-6">
                         <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                             <ul class="pagination">
                                 <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a>
                                 </li>
                                 <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                 <li class="page-item"><a class="page-link" href="#">2</a></li>
                                 <li class="page-item"><a class="page-link" href="#">3</a></li>
                                 <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                             </ul>
                         </nav>
                     </div>
                 </div>
             <?php
                }

                ?>

         </div>
     </div>
 </div>