 <div class="container-fluid">
     <div class="card shadow">
         <div class="card-header py-3 d-flex justify-content-between">

             <div>
                 <p class="text-primary m-0 fw-bold">Gamme

                 </p>
             </div>
             <div><a href="table.php?D_All=yes&see=gamme" class="btn btn-warning ">Voir tous</a></div>

         </div>

         <div class="card-body">
             <div class="row">
                 <div class="col-md-6 text-nowrap">
                     <form action="table.php?forProd=yes&see=gamme" method="get">
                         <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                             <label class="form-label">Voir&nbsp;<select class="d-inline-block form-select form-select-sm" name="filter">
                                     <?php
                                        if (isset($gamme_req) && $gamme_req != null) {
                                            if (count($gamme_req) > 20) {
                                                echo '<option value="all" selected="">All</option>
                                                <!--choisir lui meme le nombre-->
                                                <option value="10">10</option>
                                                <option value="15">25</option>';
                                            } else if (count($gamme_req) > 10 && count($gamme_req) < 20) {
                                                echo '<option value="all" selected="">All</option>';
                                                echo '<option value="5">5</option>';
                                            } else {
                                                echo '<option value="all" selected="" disabled>All</option>';
                                            }
                                        } else if (isset($gamme_req) && $gamme_req == null) {
                                            echo '<option value="0" selected="" >0</option>';
                                        }
                                        ?>

                                 </select>&nbsp;</label>
                         </div>

                 </div>


                 </form>

                 <div class="col-md-6">

                     <form action="table.php?forProd=yes&see=gamme" method="post">
                         <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Rechercher un tout..." name="search"></label></div>
                     </form>
                 </div>
             </div>
             <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                 <table class="table table-bordered table-hover table-info table-responsive table-striped
                   my-0" id="dataTable">
                     <thead>
                         <tr>
                             <th><i class="fas fa-list"></i> Catégorie</th>
                             <th><i class="fas fa-flask"></i> Nom laboratoire</th>
                             <th><i class="fas fa-card-list"></i> Nombre de produit de la gamme</th>
                             <th><i class="fas fa-edit"></i> Modifier</th>
                             <th><i class="fas fa-trash"></i> Supprimer</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            if (isset($gamme_req) && !empty($gamme_req)) {
                                foreach ($gamme_req as $gamme) {
                                    //compter le nombre de produits contenant la gamme
                                    $req = $conn->prepare("SELECT COUNT(*) AS nb FROM produit WHERE id_gamme = ?");
                                    $req->execute([$gamme['id_gamme']]);
                                    $nb = $req->fetch();
                                    $req->closeCursor();
                                    echo "<tr>
                                            <td>" . $gamme['categorie'] . "</td>
                                            <td>" . $gamme['nom'] . "</td>
                                            <td class='text-center'>" . $nb['nb'] . "</td>
                                            <td> <a href='editer.php?id=" . $gamme['id_gamme'] . "&action=gamme' class='btn btn-primary'>
                                            <i class='fas fa-edit'></i> Modifier
                                            </a></td>
                                            <td><a  href='table.php?forProd=yes&see=produit&id=" . $gamme['id_gamme']
                                        . "' class='btn btn-danger'>
                                            <i class='fas fa-trash-alt'></i> Supprimer
                                        </a></td>
                                        </tr>";
                                }
                                if (count($gamme_req) > 7) {
                                    echo '<tfoot>
                                            <tr>
                                             <th><i class="fas fa-list"></i> Catégorie</th>
                                             <th><i class="fas fa-flask"></i> Nom laboratoire</th>
                                             <th><i class="fas fa-card-list"></i> Nombre de produit de la gamme</th>
                                             <th><i class="fas fa-edit"></i> Modifier</th>
                                             <th><i class="fas fa-trash"></i> Supprimer</th>
                                            </tr>
                                        </tfoot>';
                                }
                            } else {
                                echo "<tr>
                                            <td colspan='8'><div class='alert alert-danger'>Aucune gamme trouver!</div>
                                             
                                            </td>
                                        </tr>";
                            }
                            ?>


                 </table>
             </div>
             <?php if (isset($gamme_req) && count($gamme_req) > 10) {
                ?>
                 <div class="row">
                     <div class="col-md-6 align-self-center">
                         <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                             Showing 1 to 10 of <?php if (count($gamme_req) > 10)
                                                    echo
                                                    count($gamme_req);

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