function ServiceMenu ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
	function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
		var url = base_urlHome()+"api/Usuarios/usuariomenu";
		/*ApiKey = $cookies.get('ApiKey');
		$http.defaults.headers.common["x-api-key"] = ApiKey;*/
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });

        return promise;
    }
};
function ServiceOficinas ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Usuarios/get_all_oficinas";
        /*ApiKey = $cookies.get('ApiKey');
        $http.defaults.headers.common["x-api-key"] = ApiKey;*/
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });
        return promise;
    }
};
function ServiceDepartamentos ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Carpetas/get_all_departamentos";
        /*ApiKey = $cookies.get('ApiKey');
        $http.defaults.headers.common["x-api-key"] = ApiKey;*/
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });
        return promise;
    }
};
function ServiceCarpetas ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Consulta_Datos/get_all_carpetas";
        /*ApiKey = $cookies.get('ApiKey');
        $http.defaults.headers.common["x-api-key"] = ApiKey;*/
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });
        return promise;
    }
};
function ServiceUsuarios ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Consulta_Datos/get_all_usuarios";
        /*ApiKey = $cookies.get('ApiKey');
        $http.defaults.headers.common["x-api-key"] = ApiKey;*/
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });
        return promise;
    }
};
function ServiceDepartamentosConsulta ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Consulta_Datos/get_all_departamentos";
        /*ApiKey = $cookies.get('ApiKey');
        $http.defaults.headers.common["x-api-key"] = ApiKey;*/
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });
        return promise;
    }
};
function ServiceUsuariosContrasena ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Contrasena/get_all_usuarios";
        /*ApiKey = $cookies.get('ApiKey');
        $http.defaults.headers.common["x-api-key"] = ApiKey;*/
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });
        return promise;
    }
};
function ServiceSistemasContrasenas ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Contrasena/get_all_sistemas";
        /*ApiKey = $cookies.get('ApiKey');
        $http.defaults.headers.common["x-api-key"] = ApiKey;*/
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });
        return promise;
    }
};

app.service('ServiceMenu',ServiceMenu);
app.service('ServiceOficinas',ServiceOficinas);
app.service('ServiceDepartamentos',ServiceDepartamentos);
app.service('ServiceCarpetas',ServiceCarpetas);
app.service('ServiceUsuarios',ServiceUsuarios);
app.service('ServiceUsuariosContrasena',ServiceUsuariosContrasena);
app.service('ServiceDepartamentosConsulta',ServiceDepartamentosConsulta);
app.service('ServiceSistemasContrasenas',ServiceSistemasContrasenas);