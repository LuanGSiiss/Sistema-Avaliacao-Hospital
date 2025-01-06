-- SQls usados nos arquivos

-- Buscar uma pergunta aleatoria do bd
SELECT * FROM perguntas WHERE status = true
	ORDER BY RANDOM() LIMIT 1;
	
-- Busca todas as avaliações
SELECT * FROM avaliacoes ORDER BY id_avaliacao;
