// page refresh rate
var ref = 750;
// local store of conversation length
var convoLen = 0;

$(function() {
	setChatStatus("");

	main();

	// set student's name with enter click
	$('#nameInp').keypress(function(e) {
		if (e.keyCode==13)
			setStuName();
	});

	if (getChatStatus() != "dead") {
		var clock = setInterval(function() {
			main();

			if (getChatStatus() == "dead")
				clearInterval(clock);
		}, ref);
	}
});

// main page building functions
function main() {
	liveChat();

	// refresh chat
	updateChat();
}

// if chat is live (professor is in chat room), update accordingly
function liveChat() {
	$.ajax({
	    url: '../chat/isChatOpen.php',
	    type: "POST",
	    data: {
			node: $("#c").val()
	    },
	    success: function(data) {
	    	// professor is absent
	    	if (data != "1") {
	    		setChatStatus("dead");

	    		$("#chatInp").remove();
				$("#sendButt").remove();

				// catch if student left chat but hasn't timed out
				if (typeof $("#c").val() != 'undefined') {
					setAdminMessage("Chat closed");
				}
			}
			else {
				setAdminMessage("");
				setChatStatus("live");
			}
	    }
	});
}

// replace chat box with newest messages
function updateChat() {
	$.ajax({
	    url: "getChat.php",
	    type: "POST",
	    data: {
			sentinel: $("#c").val(),
			pId: $("#p").val(),
			id: $("#sId").val(),
	    },
	    success: function(data) {
	    	// if old is shorter than new (new was content added)
	    	if (convoLen != data.length + getAdminMessage().length) {
	    		// update chat
				//setTimeout($("#messages").html(data+getAdminMessage()), 2000);
				$("#messages").html(data+getAdminMessage());

	    		// scroll to bottom of chat
				$('#convo').scrollTop(1E10);

	    		// update local store of convo length
				convoLen = data.length + getAdminMessage().length;

	    		setAdminMessage("");
			}
	    },
	    error: function() {
	        console.log("Error updating chat");
	    }
	});
}

// HTML call
function send() {
	chatSend($("#chatInp").val());
}

// actual database insertion
function chatSend(message) {
	$.ajax({
	    url: "chatSend.php",
	    type: "POST",
	    async: false,
	    data: {
			input: message,
			sentinel: $("#c").val(),
			sender: $("#sId").val()
	    },
	    error: function() {
	    	console.log("Error sending " + message);
	    	// chatSend(message);
	    }
	});
}

function setStuName() {
	$.ajax({
		url: "setStuName.php",
	    type: "POST",
	    async: false,
	    data: {
			name: $("#nameInp").val(),
			id: $("#sId").val(),
			ip: $("#ip").val()
	    },
		success: function() {
			location.reload();
		}
	});
}

function setAdminMessage(message) {
	localStorage.setItem("admin", "<p class='admin'>"+message+"</p>");
}

function getAdminMessage() {
	return localStorage.getItem("admin");
}

// "live" or "dead"
function setChatStatus(status) {
	localStorage.setItem("live", status);
}

function getChatStatus(status) {
	return localStorage.getItem("live");
}

function chatEnd() {
	$.post("chatEnd.php", {
		success: function() {
			window.location = "../find/";
		}
	});
}