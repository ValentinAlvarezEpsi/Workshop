<section id="section-view-project">	

	<a href="index.php?page=home" data-delay='{"show":"1000"}' title="Retour"><button type="button" class="btn btn-dark mb-1"><i class="fas fa-arrow-left"></i></button></a>

	<div class="card col- mb-5">
		<div class="card-header">
			<?= $project->title; ?>
		</div>
		<div class="card-body">
			<?= $project->description; ?>
		</div>
	</div>


	<div class="row">
		<?php foreach ($teams as $oneTeam):	?>
		<div class="col- col-sm-8 col-md-6 col-lg-6 col-xl-4 mb-3">	
			<div class="card">
				<div class="card-header">
					<div class="float-left align-bottom mt-1">
						<i class="fas fa-users"></i> <?= $oneTeam->name; ?>
					</div>
					<div class="float-right ">

						<?php 
						if($teamRegister) { ?>
							<a class="btn btn-secondary btn- disabled" href="index.php?page=view_project&idTeam=<?= $oneTeam->id ?>&project=<?= $idProject ?>" data-delay='{"show":"1000"}' title="S'ajouter" role="button"><i class="fas fa-user-plus"></i></a><?php
						} else { ?>
							<a class="btn btn-primary btn-sm" href="index.php?page=view_project&idTeam=<?= $oneTeam->id ?>&project=<?= $idProject ?>" data-delay='{"show":"1000"}' title="S'ajouter" role="button"><i class="fas fa-user-plus"></i></a>
						<?php
						} ?>
					</div>
				</div>
				<div class="card-body">
					<div class="container">
						<div class="row">
							<div class="col-sm"><?php

							$flag = false;

							foreach ($listUser as $userInTeam) {
								if ($userInTeam->idTeam == $oneTeam->id) { ?>
									<ul class="list-group list-group-flush">
										<li class="list-group-item"><?php 
									 		echo $userInTeam->firstname;
									 		echo " ";
											echo $userInTeam->lastname; 
											$flag = true;
									  	?></li>
									</ul><?php 
								}
							} 
							?></div>
						</div>
					</div>
					<?php
						if(!$flag) echo "Vide";
					?>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</section>