<?php
namespace App\Class;

class ConstantHelper
{
    /******************************************ALERTS E TOAST*********************************************************/
    //guards
    const GUARD_DEVELOPER = 'user';
    const GUARD_CLIENTE = 'client';

    //toast e alert
    const FEEDBACK_ERROR = 'error';
    const FEEDBACK_SUCCESS = 'success';
    const FEEDBACK_WARNING = 'warning';
    const FEEDBACK_INFO = 'info';

    //alert
    const ALERT_QUESTION = 'question';
    /******************************************TIMES -TEMPO*********************************************************/

    //cokkies
    const TIME_COKKIE_LOGIN_FORM = 2 * 30 * 24 * 3600; //2 meses

    /******************************************DEFAULTS*********************************************************/
    //padronização de paginação, limite de paginas, por pagina
    const PAGIANTE_LIMIT = 10;
    //Nada encontrado, registros vazios mensagem
    const EMPTY_REGISTERS = 'N/A';
    /******************************************PASTAS*********************************************************/

}
