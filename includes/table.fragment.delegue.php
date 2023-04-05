<div class="container-fluid">
    <h3 class="text-dark mb-4">Team </h3>
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <p class="text-primary m-0 fw-bold">Infos Délégués

                </p>
            </div>
            <div><a href="table.php?S_All=yes" class="btn btn-warning ">Voir tous</a></div>

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-nowrap">
                    <form action="table.php?onlyDel=yes&see=delegue" method="get">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <label class="form-label">Voir&nbsp;<select class="d-inline-block form-select form-select-sm" name="filter">
                                    <?php
                                    if (isset($delegue_req) && $delegue_req != null) {
                                        if (count($delegue_req) > 20) {
                                            echo '<option value="all" selected="">All</option>
                                                <!--choisir lui meme le nombre-->
                                                <option value="10">10</option>
                                                <option value="15">25</option>';
                                        } else if (count($delegue_req) > 10 && count($delegue_req) < 20) {
                                            echo '<option value="all" selected="">All</option>';
                                            echo '<option value="5">5</option>';
                                        } else {
                                            echo '<option value="all" selected="" disabled>All</option>';
                                        }
                                    } else if (isset($delegue_req) && $delegue_req == null) {
                                        echo '<option value="0" selected="" >0</option>';
                                    }
                                    ?>

                                </select>&nbsp;</label>
                        </div>

                </div>


                </form>

                <div class="col-md-6">

                    <form action="table.php?onlyDel=yes&see=delegue" method="post">
                        <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Rechercher un tout..." name="search"></label></div>
                    </form>
                </div>
            </div>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table table-bordered table-hover table-info table-responsive table-striped
                   my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-file-image"></i>Photo</th>
                            <th><i class="fas fa-key"></i>Matricule</th>
                            <th><i class="fas fa-database"></i>Nom & Prénom</th>
                            <th><i class="fas fa-address-card"></i>Adresse</th>
                            <th><i class="fas fa-mail-forward"></i>email</th>
                            <th><i class="fas fa-phone"></i>Numéro de téléphone</th>
                            <th><i class="fas fa-info"></i>Voir charge</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($delegue_req) && !empty($delegue_req)) {
                            foreach ($delegue_req as $delegue) {
                                echo
                                "<tr>
                                                <td><img class='rounded-circle me-2' width='45' height='45' src='../assets/images/delegue/" . $delegue['photo'] . "' onclick='showImage(this)'></td>
                                            <td class='text-upper'>" . $delegue['matDelegue'] . "</td>
                                            <td class='text-upper'>" . $delegue['nom'] . " " . $delegue['prenom'] . "</td>
                                            <td>" . $delegue['adresse'] . "</td>
                                            <td>" . $delegue['email'] . "</td>
                                            <td>" . $delegue['telephone'] . "</td>
                                            <td class='gaper'><a class='btn btn-google' href='infoDelegue.php?id=" .
                                $delegue['id_delegue']
                                . "'><i  class='fas fa-edit'></i> voir</a></td>
                                            
                                                </tr>";
                            }
                            if (count($delegue_req) > 7) {
                                echo '<tfoot>
                                            <tr>
                                                <th><i class="fas fa-file-image"></i>Photo</th>
                                                <th><i class="fas fa-key"></i>Matricule</th>
                                                <th><i class="fas fa-database"></i>Nom & Prénom</th>
                                                <th><i class="fas fa-address-card"></i>Adresse</th>
                                                <th><i class="fas fa-mail-forward"></i>email</th>
                                                <th><i class="fas fa-phone"></i>Numéro de téléphone</th>
                                                <th><i class="fas fa-info"></i>Voir charge</th>
                                                
                                            </tr>
                                        </tfoot>';
                            }
                        } else {
                            echo "<tr>
                                            <td colspan='8'><div class='alert alert-danger'>Aucun délégué trouver!</div>
                                             
                                            </td>
                                        </tr>";
                        }
                        ?>
                </table>
            </div>
            <?php if (isset($delegue_req) && count($delegue_req) > 10) {
            ?>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                            Showing 1 to 10 of <?php if (count($delegue_req) > 10)
                                                    echo
                                                    count($delegue_req);

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