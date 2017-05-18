explain
select u.name
	 , a.arquivo
	 , a.created_at
     , concat('../storage/app/trabalhos/', date_format(t.ano, '%Y') , '/' , t.titulo , '/arquivos/user_', u.id, '_' , a.arquivo) as caminho
  from arquivos as a
 inner join users as u
	on u.id = a.user_id
 inner join etapas as e
	on e.id = a.etapa_id
 inner join trabalhos as t
	on t.id = e.trabalho_id
 where a.etapa_id = 1;