var savedData;
var idUsuario;
var nombreUsuario;
function setValoresIniciales(savedDataP, idUsuarioP, nombreUsuarioP) {
	console.log('set ini');
    savedData = savedDataP;
    idUsuario = idUsuarioP;
    nombreUsuario = nombreUsuarioP;
    console.log(savedDataP);
}
function GetInitialInfo(objectName, setSaveInfoMethodName, setUserIdMethodName, setUserNameMethodName) {
	console.log('load');
    var unity = GetUnity();
    	
	unity.SendMessage(objectName, setSaveInfoMethodName, savedData);
    unity.SendMessage(objectName, setUserIdMethodName, idUsuario);
    unity.SendMessage(objectName, setUserNameMethodName, nombreUsuario);
        
    $.post('api/get_initial_info',
    {
        metodo: "GetInitialInfo"
    },
    function(data) {}
        );
}
function SaveInfo(id, saveData) {
	console.log('save');
    $.post('api/save_data',
    {
        data: saveData,
        id: id,
        metodo: "SaveInfo"
    },
    function(data) {}
        );
}
function SceneChanged(id, idOut, idIn) {
	console.log('scene');
    $.post('api/scene_changed',
    {
        sceneOut: idOut,
        sceneIn: idIn,
        id: id,
        metodo: "SceneChanged"
    },
    function(data) {}
        );
}
function GameEnded(id, idGame, puntos, nivel, cambio) {
	console.log('end');
    $.post('api/game_ended',
    {
        points: puntos,
        level: nivel,
        didChange: cambio,
        id: id,
        idGame: idGame,
        metodo: "GameEnded"
    },
    function(data) {}
        );
}

function setGameInfo(gameInfo, puntos, metodo){
	console.log('gameInfo');
	console.log(metodo);
	console.log(gameInfo);
	$.post('api/game_info',{
		id:idUsuario,
		info:gameInfo,
		score:puntos,
		metodo: metodo,
		success: function(data){console.log(data);}
	},function(data){});
}
