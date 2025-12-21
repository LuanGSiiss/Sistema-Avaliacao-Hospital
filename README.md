# Sistema Avaliacao Hospitalar

## Descrição do Projeto

O Sistema de Avaliação Hospitalar é uma aplicação web desenvolvida com o objetivo de permitir a coleta e análise de avaliações dos serviços prestados pelo Hospital Regional do Alto Vale do Itajaí.
O sistema possibilita a realização de avaliações, bem como o gerenciamento de perguntas, setores e dispositivos, além de oferecer uma visão mais estratégica por meio de um dashboard com indicadores.

Inicialmente, o projeto foi desenvolvido como um trabalho acadêmico, porém evoluiu posteriormente com foco em aprendizado prático de PHP, arquitetura MVC e Programação Orientada a Objetos (POO).

Atualmente, o projeto encontra-se na versão 2, sendo que toda a documentação descrita aqui refere-se exclusivamente a essa versão.

Um ponto importante do projeto é a implementação de um sistema de roteamento próprio, desenvolvido sem o uso de frameworks. Todas as requisições HTTP passam pelo index.php, que delega o controle ao núcleo da aplicação 'Core.php', responsável por interpretar a rota e chamar o controller adequado.

É importante destacar que como o objetivo principal do projeto é o aprendizado, algumas decisões técnicas não seguem, necessariamente, o padrão ideal para ambientes de produção, mas foram mantidas para fins de aprendizado.


## Funcionalidades
1. **Autenticação**
    - Sistema de login com validação de usuário e senha;
    - Controle de acesso as funcionalidades do sistema.
2. **Cadastro de Setores, Dipositivos e Perguntas**
    - Formulários completos com validação de campos;
    - Persistência dos dados em banco.
3. **Avaliação**
    - Pagina visualmente agradável e responsiva;
    - Registro de feedback textual e nota numérica;
    - Carrega perguntas com base no dispositivo e setor selecionados;
4. **Dashboard**
    - Exibição de indicadores relevantes;
    - Pagina visualmente agradável e responsiva;
    - Gráficos desenvolvidos com Charjs;


## Fluxo
1. A requisição HTTP é recebida pelo Apache que redireciona para o arquivo index.php conforme as regras definidas no .htaccess;
2. O index.php carrega o arquivo Core.php e executa o método run, passando as rotas configuradas;
3. O Core interpreta a URL, separando o recurso e os parâmetros;
4. Caso a rota seja encontrada, o método correspondente do controller definido é invocado;
5. O controller executa as regras de negócio e retorna a view apropriada ao usuário; 


## Tecnologias Utilizadas
- **Linguagens**: PHP, JavaScript, HTML e CSS;
- **Banco de Dados**: PostgreSQL;
- **Servidor Web**: Apache (XAMPP);
- **Bibliotecas**: Char.js;


## Conceitos
- Arquitetura MVC (Model-View-Controller);
- Programação Orientada a Objetos (POO);
- Roteamento manual;
- Requisições AJAX;
- Tratamento de erros e validações;
- Separação de responsabilidades;


## Padrões e Boas Práticas Aplicadas

- Separação clara entre regras de negócio, validação e persistência;
- Uso de classes validadoras específicas por entidade;
- Entidades representando o domínio do sistema;
- Controllers responsáveis apenas pelo fluxo e resposta;
- Tratamento de exceções com respostas JSON padronizadas para requisições AJAX.
- Uso de arquivos js e css globais para evitar repetir código;

## Estrutura do Projeto

```
versao01
versao02/                          
├── controllers/                            
│   ├── antigos/
│   └── controllers...
├── core/                            
│   └── Core.php
├── documentos/                            
│   ├── banco/
│       └── modelagem
│   └── estudos/
├── models/                            
│   ├── antigos/
│   ├── entidades/
│   └── models...
├── public/                            
│   ├── css/
│   └── js/
├── router/                            
│   └── routes.php 
├── service/                            
├── sql/
├── utils/
├── views/
├── .htaccess
├── config_db.php
├── config_geral.php
└── index.php
```


## Instalação

### Pré-requisitos
- PHP;
- XAMPP;
- PostgreSQL;

### Passos

1. Clone o projeto;
```bash
git clone https://github.com/LuanGSiiss/Sistema-Avaliacao-Hospital.git
```

2. Execute o script de criação do banco de dados disponível na pasta 'sql/';

3. Realize o cadastro inicial de usuário diretamente no banco de dados;

4. Inicie o Apache através do XAMPP;

5. Acesse o sistema pelo navegador utilizando a URL base do projeto, por exemplo: 
```bash
http://localhost/Luang/Sistema-Avaliacao-Hospital/versao02
```

* Ajuste a URL conforme a estrutura de diretórios do seu ambiente local;


## Limitações Conhecidas

- Sistema de usuários básico, sem níveis de hierarquia e sem possibilidade de cadastro diretamente pelo sistema;
- Autenticação simplificada, sem uso de hash ou mecanismos avançados de criptografia;
- Ausência de formulários com grupos de perguntas, sendo exibida apenas uma pergunta por vez, com carregamento sequencial das próximas avaliações;
- Sistema não preparado para ambiente de produção;

## Demonstração

![Tela de Avaliação](/versao02/documentos/prints/avaliacao-sem-url.png)
![Consulta de Perguntas](/versao02/documentos/prints/consulta-de-perguntas.png)
![Dashboard 1](/versao02/documentos/prints/dashboard1.png)
![Dashboard 2](/versao02/documentos/prints/dashboard2.png)