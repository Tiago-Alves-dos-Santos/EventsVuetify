let Settings = {
    alertData: (titulo, texto, icon) => {
        return {
            titulo: titulo,
            texto: texto,
            icon: icon
        };
    },
    arrayIsEmpty: (array) => Array.isArray(array) && array.length == 0 ? true : false,
    objectIsEmpty: (object) => {
        for (var prop in object) {
            if (object.hasOwnProperty(prop)) return false;
        }
        return true;
    },
    convertTimeString: (time_string) => {
        let [hours, minutes, seconds] = time_string.split(':');
        return hours.padStart(2, '0') + ':' + minutes.padStart(2, '0');
    }

};
//bloquear atributos do objeto
Object.seal(Settings);

export default Settings;
