-- ****************************TCC PROCEDURES/TRIGGERS*************************************

/**
* Não inserir trabalho em etapa inativa, onde o campo 'status' da tabela
* etapa_anos assumem os possíveis valores: 1 == Ativa ou 0 == Inativa
*/


/**
* Não inserir uma pessoa com o status inativo como coordenador da disciplina
* 
*/

delimiter #
create procedure pr_verifica_status_users(inout result int)
begin
	if((select u.ativo
		 from membro_bancas as mb
		inner join users as u
		   on u.id = mb.user_id
		where mb.id = result) <> 1) then
		
		set result = false;
	else
		set result = true;
    
	end if;
end#
delimiter ;

-- Como usar
-- set @id = 17;
-- call pr_verifica_status_users(@id);
-- select @id;




-- ********************************CCONT TRIGGERS*****************************************

/**

* Não deixar fazer lançamentos em períodos fechados

*

*/

delimiter #

create trigger tr_verifica_data_lanc_periodo_fechado before insert on Lancamento

for each row

begin

if (select situacao

from Periodo

where id_periodo = new.id_periodo) <> 1 then

SIGNAL SQLSTATE '45000'

SET MESSAGE_TEXT = 'Período Fechado';

end if;

end#

delimiter ;


/**

* Validações tabela Pessoa

*/

delimiter #

create trigger tr_verificacao_pessoa before insert on Pessoa

for each row

begin

-- verifica estados

if(new.estado not in

('AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','R

O','RR','RS','SC','SE','SP','TO')) then

SIGNAL SQLSTATE '45000'

set MESSAGE_TEXT = 'Não é um estado brasileiro';

end if;

-- verifica sexo

if(new.sexo not in ('M', 'F')) then

SIGNAL SQLSTATE '45000'

SET MESSAGE_TEXT = 'O campo sexo deve ser M ou F';

end if;

-- data nascimento

if(year(new.data_nascimento) >= year(now())) then

SIGNAL SQLSTATE '45000'

set MESSAGE_TEXT = 'Ano não pode ser maior ou igual que o ano

atual';

elseif((year(new.data_nascimento) < 1900)) then

SIGNAL SQLSTATE '45000'

set MESSAGE_TEXT = 'Ano deve ser maior que 1900';

end if;

end#

delimiter ;

/**

* Validações tabela Matrícula

*/

delimiter #

create trigger tr_verificacao_matricula before insert on Matricula

for each row

begin

-- Verifica Matricula

if exists (select *

from Matricula

where id_aluno = new.id_aluno

and situacao = 1) then

SIGNAL SQLSTATE '45000'

set MESSAGE_TEXT = 'O aluno já está matriculado em uma turma.';

end if;

-- Verifica situacao da Pessoa

if ((select p.ativo

from Pessoa p

inner join Aluno a

on a.id_pessoa = p.id_pessoa

where a.id_aluno = new.id_aluno) <> 1) then

SIGNAL SQLSTATE '45000'

set MESSAGE_TEXT = 'Aluno(a) não está em situação ativa.';

end if;

end#;

delimiter ;

/**

* Não deixar mais de um professor na mesma turma

*/

delimiter #

create trigger tr_verifica_professor_turma before insert on Turma

for each row

begin

if exists (select *

from Turma

where id_servidor = new.id_servidor) then

SIGNAL SQLSTATE '45000'

set MESSAGE_TEXT = 'Já existe professor para essa turma';

end if;

end#;

delimiter ;

/**

* Verificações na tabela Período

*/

delimiter #

create trigger tr_verificao_periodo before insert on Periodo

for each row

begin

-- Verificação da situação do período

if(new.situacao > 1) or (new.situacao < 0) then

SIGNAL SQLSTATE '45000'

set MESSAGE_TEXT = 'Situação inválida. 1 = ativa / 2 = não ativa';

end if;

-- Verificação do ano, sempre estar no ano corrente

if(new.ano <> year(now())) then

SIGNAL SQLSTATE '45000'

set MESSAGE_TEXT = 'O ano deve ser o ano atual';

end if;

-- Verificação dos meses

if(new.mes not in ('01','02','03','04','05','06','07','08','09','10','11','12')) then

SIGNAL SQLSTATE '45000'

set MESSAGE_TEXT = 'Mês inválido.';

end if;

end#

delimiter ;

/**

* Vericicações da tabela ItemLancamento

*/

delimiter #

create trigger tr_verificao_itemlancamento before insert on ItemLancamento

for each row

begin

-- Verificação da data de lançamento ser MENOR que a data do documento

if(new.data_lancamento < new.data_doc) then

SIGNAL SQLSTATE '45000'

SET MESSAGE_TEXT = 'Data de lançamento não pode ser menor que a

data do documento';

end if;

-- Verificação da quantidade, deve ser maior que zero.

if(new.qnt <= 0) then

SIGNAL SQLSTATE '45000'

SET MESSAGE_TEXT = 'Quantidade deve ser maior que zero.';

end if;

-- Verificação do valor do item, deve ser maior que zero.

if(new.valor <= 0) then

SIGNAL SQLSTATE '45000'

SET MESSAGE_TEXT = 'O valor do item deve ser maior que zero.';

end if;

end#

delimiter