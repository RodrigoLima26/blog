angular.module('app.controllers', [])


/************************************************************************************
 *************************** uploadFotoContractCtrl *******************************/
.controller('uploadFotoContractCtrl', ['$scope', '$http', 'Contracts', 'Agenda', function ($scope, $http, Contracts, Agenda) {

    $scope.contracts = [];
	$scope.agenda = [];

	$scope.upload = {
		percent: 0,
		contract_id: null,
		agenda_id: null,
		loading: false,
		responses: [],
	};

	$scope.clearUpload = function() {
		$scope.upload.percent = 0;
		$scope.upload.responses = [];
	}

	/* load contracts */
	$scope.loadContracts = function() {

		$scope.loading = true;

		/* load */
		Contracts.all().then(function(data) {
			$scope.loading = false;
			$scope.contracts = data;
		});

	}

	/* load agenda */
	$scope.loadAgenda = function(contract_id) {

		$scope.loading = true;

		/* load */
		Agenda.all(contract_id).then(function(data) {
			$scope.loading = false;
			$scope.agenda = data;
		});

	}

	/* upload photo */
	$scope.uploadFiles = function(files, contract_id, agenda_id) {

		$scope.clearUpload();
		var percentByFile = (100/files.lenght);

		Array.prototype.forEach.call(files, function(file) { 

			$scope.upload.loading = true;

	    	var fd = new FormData();

		    fd.append("file", file);
		    fd.append("contract_id", contract_id);
		    fd.append("agenda_id", agenda_id);

		    $http.post('/master/fotos/upload', fd, {
		        withCredentials: true,
		        headers: {'Content-Type': undefined },
		        transformRequest: angular.identity,
		    })

		    .then(function(response) { 
		    		$scope.upload.responses.push(response.data);
		    		$scope.upload.percent += percentByFile;
		    		$scope.upload.loading = false;

		    		console.log($scope.upload.percent);
		    	}
		    )

		    .catch(function(error) { 	
		    		console.log(error);
	    			$scope.upload.responses.push(error.data);
	    			$scope.upload.percent += percentByFile;
	    			$scope.upload.loading = false;
	    		}
	   		);

		});

	};

	/* init */
	$scope.loadContracts();

}])


/************************************************************************************
 *************************** indetificationController *******************************/
.controller('identificationController', 
					['$scope', '$http', 'Contracts', 'Correios', 'Courses', 'GraduationClothes',
			function ($scope,   $http,   Contracts,   Correios,   Courses,   GraduationClothes) {

	$scope.cities = [];
	$scope.contracts = [];
	$scope.contract = {};

	$scope.foundCep = false;
	$scope.loadingCities = false;

	// load States
	Correios.getStates().then(function(data){
		$scope.states = data;
	});

	// load Courses
	Courses.all().then(function(data){
		$scope.courses = data.data;
	});

	// load GBS
	GraduationClothes.getGbs().then(function(data){
		$scope.gbss = data.data;
	});

	// load GGS
	GraduationClothes.getGgs().then(function(data){
		$scope.ggss = data.data;
	});

	/* load contracts */
	$scope.loadContracts = function() {

		$scope.loading = true;

		/* load */
		Contracts.all().then(function(data) {
			$scope.loading = false;
			$scope.contracts = data;
		});

	}

	$scope.getContract = function(number) {

		$scope.contract = {};
		$scope.loading = true;

		/* load */
		Contracts.getQ(number, 1).then(function(data) {
			
			if (data.length > 0) {
				$scope.contract = data[0];
				$scope.loadParticipations($scope.contract.id);
			}

			$scope.loading = false;
			
		});

	}

	/* order by list */
	$scope.orderByParticipants = function() {
		return 'participant.name';
	}

	/* load participations */
	$scope.loadParticipations = function(contract_id) {

		$scope.loading = true;

		/* load */
		Contracts.getParticipations(contract_id).then(function(data) {
			$scope.loading = false;
			$scope.contract.participations = data;
		});

	}

	/* load cities */
	$scope.loadCities = function(uf) {

		$scope.foundCep = true;
		$scope.loadingCities = true;

		$http.get('/logistics/correios/cities/'+uf)

		.then(function(response) {
			$scope.loadingCities = false;
			$scope.foundCep = false;
			$scope.cities = response.data.data;
		});
	}

	/* load CEP */
	$scope.loadCEP = function(zip_code, forceLoad) {
		
		if (zip_code != '' && zip_code != null && 
		   (forceLoad || ($scope.participation.participant.address == '' || $scope.participation.participant.address == null))) {
		   	
			$scope.loadingCep = true;
			$scope.foundCep = false;

			Correios.getCEP(zip_code).then(function(cep) {

				$scope.cep = cep.data;
				$scope.loadingCep = false;
				$scope.foundCep = true;

				// bind model
				$scope.participation.participant.address = $scope.cep.address;
				$scope.participation.participant.address_district = $scope.cep.address_district;

				$scope.participation.participant.city_name = $scope.cep.city_name;
				$scope.participation.participant.city_id = $scope.cep.city_id;
				$scope.participation.participant.city_state = $scope.cep.city_state;

				// set City
				$scope.cities = [];
				$scope.cities.push( { city_id:   $scope.participation.participant.city_id, 
									  city_name: $scope.participation.participant.city_name } );

				// focus
				$('#address_number').focus();

			})

			.catch(function(error) {

				$scope.cep = null;
				$scope.foundCep = false;
				$scope.loadingCep = false;	

			});
		}
	}

	/**
	 * save Identification data
	 */
	$scope.saveIdentification = function(participation) {

		$http.post('/master/identificacao/identify', participation).

		then(function(response) {

			$scope.clearParticipant();
			$scope.foundCep = false;

			// add to list
			if (participation.index >= 0)
				$scope.contract.participations.splice(participation.index, 1);

			$scope.contract.participations.push(response.data.data);

			$('#cpf').focus();

		}, function(response) {
			
			participation.participant._validation = response.data.validation;

		});
		
	}

	/**
	 * delete Identification data
	 */
	$scope.deleteParticipation = function(id, index) {

		if (confirm('Deseja realmente remover Participante desse Contrato?')) {
			Contracts.destroyParticipation(id).then(function(response) {

				$scope.contract.participations.splice(index, 1);

			}, function(response) {
				
				// errors
				console.log(JSON.stringify(response));

			});
		}
	}

	/**
	 * try to load data by CPF
	 */
	$scope.loadByCPF = function(participant, contract_id) {
		
		if((participant.cpf != null) && (participant.cpf != "")) {

			$http.get('/master/identificacao/loadByCPF/', {
				params: {
					cpf: participant.cpf,
					id: participant.id
				}
			}).

			then(function(response) {

				data = response.data.data;

				// check if Participant already Participate of this Contract
				let alreadyInThisContract = false;

				angular.forEach(data.participations, function(value, key) {
					if (value.contract_id == contract_id) {
						alreadyInThisContract = true;
						return false;
					}
				});

				if (!alreadyInThisContract) {
					participant.id = data.id;
					participant.name = data.name;
					participant.rg = data.rg;
					participant.zip_code = data.zip_code;
					participant.address = data.address;
					participant.address_number = data.address_number;
					participant.address_complement = data.address_complement;
					participant.address_district = data.address_district;
					participant.city_id = data.city_id;
					participant.city_name = data.city_name;
					participant.city_state = data.city_state;
					participant.phone = data.phone;
					participant.mobile_phone = data.mobile_phone;
					participant.email = data.email;

					// set City
					$scope.cities = [];
					$scope.cities.push( { city_id: participant.city_id, 
										  city_name: participant.city_name } );
				}

			}, function(error) {
				
				

			});
		}

	}

	/**
	 * clear
	 */
	$scope.clearParticipant = function() {

		$scope.participation = {
			contract_id: $scope.contract.id,
			participant: { }
		}

		$scope.cities = [];

	}

	/**
	 * select Participation / Participant
	 */
	$scope.selectParticipant = function(participation, index) {
		
		$('#modal-id').modal();

		$scope.cities = [];
		$scope.cities.push( { city_id: participation.participant.city_id, 
							  city_name: participation.participant.city_name } );

		$scope.participation = participation;
		$scope.participation.index = index;

	}

	/* init */
	$scope.loadContracts();
	$scope.loadingCep = false;
	$scope.clearParticipant();

}])
