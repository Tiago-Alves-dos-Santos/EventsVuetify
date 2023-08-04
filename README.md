<!--
Readme template -> https://github.com/othneildrew/Best-README-Template
## Guards - Table - Model

## Sessões


## Cokkies


## Z-index 

-->

<a name="readme-top"></a>

<!-- PROJETO LOGO -->
<br />
<div align="center">
  <a href="https://github.com/Tiago-Alves-dos-Santos/Covid19">
    <img src="public/img/favicon/favicon_100px.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Evento Fácil</h3>

  <p align="center">
    Calendario de eventos 
    <!-- <br />
    <a href="URL_DOCS"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="URL_SERVIDOR">View Demo</a>
    ·
    <a href="https://github.com/othneildrew/Best-README-Template/issues">Report Bug</a>
    ·
    <a href="https://github.com/othneildrew/Best-README-Template/issues">Request Feature</a> -->
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
    <li><a href="#licença">Licença</a></li>
    <li><a href="#contato">Contato</a></li>
    <!-- <li><a href="#agradecimentos">Agradecimentos</a></li> -->
    <li><a href="#observação">Observação</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## Sobre
<img src="public/img/covid19.gif" />
O sistema ‘Evento Fácil’ é um sistema de cadastro de eventos básico, que exibE de forma fácil os eventos. O sistema tem por maior finalidade fins estudantis, usado para demonstrar domínio sobre as tecnologias utilizadas com um ‘clean code’ 
<!-- --- **N/A** --- -->

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>

<!-- FUNCIONALIDADES -->
## Funcionalidades

- [x] Calendário de exibição
- [x] Cadastrar, editar e excluir evento
- [x] Definir cor do evento
- [x] Definir status do evento
    - [x] Em andamento
    - [x] Pendente
    - [x] Concluído 
    - [x] Cancelado
- [x] Controle de status de evento automático(CRON JOBS)
- [x] Testes unitários, usando a abordagem TDD
- [x] Multi linguagens suportadas
    - [x] English
    - [x] Português-BR
    - [ ] Português

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
        git clone url_projeto -b main || git clone --depth 1 --branch <tag_name> <repo_url>
    ~~~
3. Duplique o arquivo `.env.example` e retire o `.example`
4. Configure as variaveis de conexao com o banco de dados
5. Execute 
    ~~~php
        composer install 
    ~~~
6. Caso queira fazer mudanças com o sass ou usar o vite execute 
    ~~~js
        npm install && npm run dev
    ~~~ 
7. Instale as migrations com as seeds 
   ~~~php
        php artisan migrate --seed
   ~~~
8. Execute 
   ~~~php
        php artisan key:generate 
   ~~~
9. Execute 
    ~~~
        php artisan serve
    ~~~


<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>



<!-- USAGE EXAMPLES -->
## Modo de uso
--- **N/A** ---
<!-- Use este espaço para mostrar exemplos úteis de como um projeto pode ser usado. Capturas de tela adicionais, exemplos de código e demonstrações funcionam bem neste espaço. Você também pode criar links para mais recursos. _Para mais exemplos, consulte a [Documentação](https://example.com)_
como por exemplo gifs, links para video etc
:movie_camera: 
<img src="public/img/covid19.gif" /> -->

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>


<!-- COLABORADORES -->
## Colaboradores
 --- **N/A** ---

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>


## Versão atual
:heavy_check_mark:   --- **N/A** ---


<!-- LICENÇA -->
## Licença
--- **N/A** ---
<!-- Distribuído sob a licença MIT. Veja `LICENSE.txt` para mais informações. -->

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>



<!-- CONTACT -->
## Contato
Tiago Alves dos Santos

Formas de contato: 
<br>

[![Whatsapp][whatsapp-shield]][whatsapp-url]
[![Telegram][telegram-shield]][telegram-url]

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p>



<!-- AGRADECIMENTOS -->
<!-- ## Agardecimentos

Use este espaço para listar os recursos que você considera úteis e aos quais gostaria de dar crédito. Eu incluí alguns dos meus favoritos para começar!

* [Choose an Open Source License](https://choosealicense.com)
* [GitHub Emoji Cheat Sheet](https://www.webpagefx.com/tools/emoji-cheat-sheet)
* [Malven's Flexbox Cheatsheet](https://flexbox.malven.co/)
* [Malven's Grid Cheatsheet](https://grid.malven.co/)
* [Img Shields](https://shields.io)
* [GitHub Pages](https://pages.github.com)
* [Font Awesome](https://fontawesome.com)
* [React Icons](https://react-icons.github.io/react-icons/search)

<p align="right">(<a href="#readme-top">Voltar ao topo</a>)</p> -->

### Observação
<p>
    O laravel 9 só suporta o vue 3, até suporta o vue 2, mas da conflito com vite. O vue 3 exige a vuetify 3, porém o vuetify 3 não possui mais o componente 'v-calendar' que vai ser essencial para o projeto, <a href="https://www.reddit.com/r/vuetifyjs/comments/11cuvqa/what_happened_to_the_calendar_in_vuetify_3/?rdt=47689" target="_blank">veja aqui</a> e na  <a href="https://vuetifyjs.com/en/labs/introduction/#up-next" target="_blank">documentação oficial do vuetify</a>.
    De acordo com documentação oficial o 'v-calendar' ainda vai ser inserido no vuetify 3.<br>
    <i>O primeiro trimestre de 2023 era a meta original, mas devido à complexidade do componente, foi adiado para o segundo trimestre de 2023.</i> - Vuetify3
</p>
<br>
<p>
    Então com situação acima explicada, decidi fazer esse projeto na versão 8 mais recente do laravel pois ela suporta o vue 2 e tem o componente necessario para aplicação.
    Se fosse realmente necessario usar vue 3, eu usaria laravel 9 ou 10 e criaria o calendario na mão, cada caso é um caso. Nesse caso, para que reinventar a roda!?<br>
    Quando lançarem o component pretendo fazer a migração para laravel 9 e vue 3. <a href="https://laravel.com/docs/9.x/upgrade" target="_blank">Guia de atualização.</a>.
</p>


<!-- MARKDOWN -->
[whatsapp-shield]: https://img.shields.io/badge/WhatsApp-25D366?style=for-the-badge&logo=whatsapp&logoColor=white
[whatsapp-url]: https://wa.link/h5vlzo
[telegram-shield]: https://img.shields.io/badge/Telegram-2CA5E0?style=for-the-badge&logo=telegram&logoColor=white
[telegram-url]: https://t.me/TiagoAlves2001
[linkedin-shield]: https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white
[linkedin-url]: https://www.linkedin.com/in/tiago-alves-96699a189/
[portfolio-shield]: https://img.shields.io/badge/PORTFOLIO-%20CLIQUE%20AQUI%20-%20BLACK
[portfolio-url]: https://wa.link/h5vlzo


