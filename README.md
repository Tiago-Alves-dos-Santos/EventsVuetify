<a name="readme-top"></a>

<!-- PROJETO LOGO -->
<br />
<div align="center">
  <a href="https://github.com/Tiago-Alves-dos-Santos/Covid19">
    <img src="public/img/favicon/favico.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Evento Fácil</h3>

  <p align="center">
    Calendario de eventos 
  </p>

  [![portfolio][portfolio-shield]][portfolio-url]
  [![linkedin][linkedin-shield]][linkedin-url]
</div>




<!-- MENU -->
<details>
  <summary>MENU</summary>
  <ol>
    <li>
      <a href="#sobre">Sobre</a>
    </li>
    <li><a href="#funcionalidades">Funcionalidades</a></li>
    <li><a href="#tecnologias-utilizadas">Tecnologias Utilizadas</a></li>
    <li><a href="#instalação">Instalação</a></li>
    <li><a href="#modo-de-uso">Modo de uso</a></li>
    <li><a href="#colaboradores">Colaboradores</a></li>
    <li><a href="#versão-atual">Versão atual</a></li>
    <li><a href="#implementações-futuras">Implementações futuras</a></li>
    <li><a href="#licença">Licença</a></li>
    <li><a href="#contato">Contato</a></li>
    <li><a href="#observação">Observação</a></li>
  </ol>
</details>



<!-- SOBRE -->
## Sobre
<img src="public/img/readme/index.png" />
O sistema ‘Evento Fácil’ é um sistema de cadastro de eventos básico, que exibe de forma fácil os eventos. O sistema tem por maior finalidade fins estudantis, usado para demonstrar domínio sobre as tecnologias utilizadas.
<!-- --- **N/A** --- -->

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>

<!-- FUNCIONALIDADES -->
## Funcionalidades

- [x] Calendário de exibição
- [x] Cadastrar, editar e excluir evento
- [x] Definir cor do evento
- [x] Definir status do evento(CRON JOBS / OBSERVERS)
    - [x] Em andamento
    - [x] Pendente
    - [x] Concluído 
    - [x] Cancelado
- [ ] Execução em tempo real
- [x] Testes unitários, usando a abordagem TDD

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>

## Tecnologias Utilizadas
1. FRONT-END
    * HTML 5
    * CSS 3
    * VUE 2
    * VUETIFY 2
    * SASS
    * BLADE
    * NODE 18.17.0(LTS)
    * NPM 9.6.7
2. BACK-END
    * PHP 8.1.9
    * LARAVEL 8.6.12
    * INERTIA 0.6.9



<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>

<!-- GETTING STARTED -->
## Instalação

1. Certifique-se de ter instalado na sua máquina o php e node(npm) correto, se usa docker verificar a imagem
2. Faça o 
    ~~~git
        git clone --depth 1 --branch <tag_name> <repo_url> || git clone url_projeto -b main
    ~~~
3. Duplique o arquivo `.env.example` e retire o `.example`
4. Configure as variaveis de conexao com o banco de dados
5. Execute 
    ~~~php
        composer install 
    ~~~
6. Instale as migrations com as seeds 
   ~~~php
        php artisan migrate --seed
   ~~~
7. Execute 
   ~~~php
        php artisan key:generate 
   ~~~
8. Execute para iniciar o servidor
    ~~~
        php artisan serve
    ~~~
9. Em outro terminal execute para executar as CRON JOBS 
    ~~~
        php artisan schedule:work
    ~~~
10. Passo opcional, caso queira fazer mudanças no front-end (vue || sass)
    ~~~js
        npm install && npm run dev
    ~~~ 


<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>



<!-- USAGE EXAMPLES -->
## Modo de uso
--- **N/A** ---

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>


<!-- COLABORADORES -->
## Colaboradores
 --- **N/A** ---

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>


## Versão atual
:heavy_check_mark:    **v1.0.0-beta** 

## Implementações futuras

<ul>
    <li>Repetição de eventos, exemplo: aniversário(repetição anual)</li>
    <li>Execução em tempo real</li>
    <li>Login</li>
    <li>Consumo da API do google calendar</li>
</ul>

<!-- LICENÇA -->
## Licença
--- **N/A** ---

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>



<!-- CONTACT -->
## Contato
Tiago Alves dos Santos

Formas de contato: 
<br>

[![Whatsapp][whatsapp-shield]][whatsapp-url]
[![Telegram][telegram-shield]][telegram-url]

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>

### Observação
Não fiz o sistema em tempo real pois quis deixar ele simples, apenas um agendador de eventos com controle de 'status', deixei uma lista de implementações que o projeto poderia ou poderá receber



<!-- MARKDOWN -->
[whatsapp-shield]: https://img.shields.io/badge/WhatsApp-25D366?style=for-the-badge&logo=whatsapp&logoColor=white
[whatsapp-url]: https://wa.link/h5vlzo
[telegram-shield]: https://img.shields.io/badge/Telegram-2CA5E0?style=for-the-badge&logo=telegram&logoColor=white
[telegram-url]: https://t.me/TiagoAlves2001
[linkedin-shield]: https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white
[linkedin-url]: https://www.linkedin.com/in/tiago-alves-96699a189/
[portfolio-shield]: https://img.shields.io/badge/PORTFOLIO-%20CLIQUE%20AQUI%20-%20BLACK
[portfolio-url]: https://wa.link/h5vlzo


