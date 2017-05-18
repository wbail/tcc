angular.module('aplicacao').controller('PrimeiroController', function($scope) {


	$scope.nome = 'Guilherme Bail';

	$scope.iniciado = true;


	$scope.alunos = ['Aluno 1', 'Aluno 2', 'Aluno 3', 'Aluno 4', 'Aluno 5'];


	$scope.finalizar = function () {
		$scope.iniciado = false;
	};

	$scope.iniciar = function () {
		$scope.iniciado = true;
	};


	
	$scope.addTelefone = function(){
		
	    var newEle = angular.element('<input id="telefone" title="(42) XXXXXXXXX" type="text" class="form-control" /><br>');
	    var target = document.getElementById('target');
	    angular.element(target).append(newEle);
	
  	}




});