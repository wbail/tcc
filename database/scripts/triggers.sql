-- ****************************TCC PROCEDURES/TRIGGERS*************************************

/**
 * Não inserir trabalho em etapa inativa, onde o campo 'status' da tabela
 * etapa_anos assumem os possíveis valores: 1 == Ativa ou 0 == Inativa
 */

delimiter #
create trigger tr_verifica_status_etapa_trabalhos before insert on etapa_trabalhos
for each row
begin
    -- Se 'ativa' está falso
    if((select ea.ativa
		  from etapa_anos ea
		 where ea.id = new.etapaano_id) <> 1) then
		signal sqlstate '45000'
		set message_text = 'O prazo para envio está encerrado.';
    end if;

end#
delimiter ;

/**
 * Não deixar um aluno em mais de um trabalho
 * Não deixar um trabalho com mais de 2 alunos
 */

delimiter #
create trigger tr_verifica_aluno_academico_trabalhos before insert on academico_trabalhos
for each row
  begin

    -- Verifica se um trabalho tem mais de dois alunos
    if((select count(atr.trabalho_id)
        from academico_trabalhos atr
        where atr.trabalho_id = new.trabalho_id) > 1) then
      signal sqlstate '45000'
      set message_text = 'O trabalho já possui o máximo de alunos permitidos.';
    end if;

  end#
delimiter ;


/**
 * Não inserir uma pessoa com o status inativo como coordenador da disciplina
 * -- Como usar pr_verifica_status_users
	-- set @id = 17;
	-- call pr_verifica_status_users(@id);
	-- select @id;
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


/**
 * Na tabela coordenador_cursos não deixar inserir uma data inicial maior que a data final
 * Só existir um coordenador por curso
 * Verificação se existe o coordenador e curso já inseridos
 */

delimiter #
create trigger tr_validacoes_coordenador_cursos before insert on coordenador_cursos
for each row
begin
	
    -- Verificação de datas inicial e final
    if(new.fim_vigencia < new.inicio_vigencia) then
		signal sqlstate '45000'
		set message_text = 'Data final maior que a data inicial.';
    end if;
    
    -- Verificação se existe o coordenador e curso já inseridos
    if ((select count(cc.coordenador_id)
		   from coordenador_cursos cc
		  where exists(select *
				         from coordenador_cursos cc)
		    and cc.coordenador_id = new.coordenador_id
		    and cc.curso_id = new.curso_id) > 0) then
	
		signal sqlstate '45000'
		set message_text = 'Este(a) professor(a) já coordenador(a) deste curso.';
	end if;
    
    -- Verificação se o curso já possui um coordenador
    if((select count(curso_id)
		  from coordenador_cursos cc
		 where cc.curso_id = new.curso_id) > 0) then
		signal sqlstate '45000'
		set message_text = 'Este curso já possui um(a) professor(a) coordenador(a).';
    end if;
        
end#
delimiter ;

/**
 * Rotina desabilita a etapa quando acaba o tempo
 */
delimiter $
create event e_muda_status_table_etapa_anos
  on schedule every 1 day
  do
  begin

    update etapa_anos ea
    set ea.ativa = 0
    where ea.ativa = 1
    and ea.data_final < now();

  end $
delimiter ;

/**
 * Rotina desabilita ano letivo quando acaba o tempo
 */
delimiter $
create event e_muda_status_table_ano_letivos
  on schedule every 1 day
  do
  begin

    update ano_letivos
    set ativo = 0
    where data < now();

  end $
delimiter ;

/**
 * Não deixar um aluno em mais de um trabalho
 * Não deixar um trabalho com mais de 2 alunos
 */

delimiter $
create trigger tr_verifica_aluno_academico_trabalhos_before_update before update on academico_trabalhos
  for each row
  begin

    -- Verifica se um trabalho tem mais de dois alunos
    if((select count(atr.trabalho_id)
        from academico_trabalhos atr
        where atr.trabalho_id = new.trabalho_id) > 1) then
      signal sqlstate '45000'
      set message_text = 'O trabalho já possui o máximo de alunos permitidos.';
    end if;

  end;
$ delimiter ;

/**
 * Verifica se existe um trabalho vinculado ao aluno antes de excluir o aluno
 */

delimiter $
create trigger tr_verifica_aluno_academico_trabalhos_before_delete before delete on academico_trabalhos
for each row
  begin
    -- Verifica se o aluno já tem um trabalho
    if((select count(atr.academico_id)
        from academico_trabalhos atr
        where atr.academico_id = academico_id) > 0) then
      signal sqlstate '45000'
      set message_text = 'O aluno já está vinculado a um trabalho.';
    end if;
  end; $
delimiter;