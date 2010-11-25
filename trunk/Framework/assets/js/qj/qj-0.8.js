/**
 * Qj Module
 *
 * @author		Evance Soumaoro
 * @copyright   Copyright (c) 2009 - 2011, Evansofts.
 * @link		http://evansofts.com
 * @version		0.1
 * @filesource  Qj.js 
 */
 
//======================================    CORE   =========================================
 
if(typeof(Qj)=="undefined") { 
	var Qj={};
} 
else {
	if(typeof(Qj)!="object"){ throw new Exception("Qj is already defined in the global namespace");};
};

//Constants
Qj.Types=function(){ /* namespace for types */};
Qj.Types.Undefined=function(){ return "undefined";};
Qj.Types.Function=function(){ return "function"; };
Qj.Types.Object=function() { return "object"; };
Qj.Types.Array=function() { return "array"; };

//executed when page loading	
Qj.Init=function(fn){
	(function(){
		if(typeof(fn)==Qj.Types.Function()) fn();           
    }());
};

//executed wehe jquery is ready
Qj.Ready=function (fn){
    if(typeof($)!=Qj.Types.Function()){	
        throw new Exception("Jquery is not loaded");
        return false;
    }
    $(function(){
        if(typeof(fn)==Qj.Types.Function()){
           Qj.Ui();
           fn();
		}
    });  
};
	
//jquery selector
Qj.Select=function(selector){
	return $(selector);
};

//iterator with callback
Qj.Iterator= function(collection,fn){
	if(typeof(fn)==Qj.Types.Function()) {
		for(i in collection){
			fn(collection[i]);
		}
	}
};

//collection
Qj.Collection=function(items){
	if(typeof(items)==Qj.Types.Object()){
		this.Items=items;
	}
	else{
		this.Items=new Array();
	}
	this.Count=this.Items.length;
	
	this.Value=function(index){
		return this.Items[index];
	};
	
	this.Push=function(value){
		this.Items.push(value);
	};
	this.Pop=function(){
		return this.Items.pop();
	};
	
	this.Unshift=function(value){
		this.Items.unshift(value);
	};
	this.Shift=function(){
		return this.Items.shift();
	};
	
	this.Each=function(callback){
		new Qj.Iterator(this.Items,callback);
	};
	
};


//Id generator
Qj.Id=function(prefix){
	return prefix+"_"+new Date().getTime();
};


//======================================    UTILIS    =========================================

//regex validator
Qj.Matcher=function() { /* namespace for matcher */};

//predefined regex
Qj.Matcher.Numeric=/^\d+$/;
Qj.Matcher.Alphabetic=/^[a-z]+$/;
Qj.Matcher.Login=/\w{6,}/;
Qj.Matcher.Password=/\w{6,}/;
Qj.Matcher.Name=/\w{6,}/;
Qj.Matcher.Email=/\w{6,}/;
Qj.Matcher.Website=/\w{6,}/;
Qj.Matcher.Text=/\w{6,}/;

//match
Qj.Matcher.Match=function (Pattern, Subject,OnSuccess, OnFail){
    var Result=Subject.match(Pattern);
    if(Result){
		if(OnSuccess!=null) OnSuccess(Subject,Result);   
	}
    else {
       if(OnFail!=null) OnFail(Subject,Result);
	}
    return Result;
};

//test
Qj.Matcher.Test=function(Pattern, Subject,OnSuccess, OnFail){
	var Result=Pattern.test(Subject);
    if(Result){
		if(OnSuccess!=null) OnSuccess(Subject,Result);   
	}
    else {
       if(OnFail!=null) OnFail(Subject,Result);
	}
    return Result;
};

//form validation
Qj.Form=function(validators){
	this.Validators=validators;	
};

Qj.Form.prototype.Validate=function(){
	var assertion=true;
	Qj.Iterator(this.Validators.Items, function(item){
		this.item=item;
		Qj.Matcher.Test(
			item.Rule,
			Qj.Select("#"+this.item.Id).val(),
			function(){	
				Qj.Select("#"+this.item.Id+"+ span" ).remove();
				Qj.Select("#"+this.item.Id).removeClass("notvalid").addClass("valid")
				.after('<span class="valid"></span>');
			},
			function(){
				Qj.Select("#"+this.item.Id+"+ span" ).remove();
				Qj.Select("#"+this.item.Id).removeClass("valid").addClass("notvalid")
				.after('<span class="notvalid">'+this.item.Message+'</span>');
				assertion=false;
			});
	});
	return assertion;
};

//validators inherite from collectionvb 
Qj.Form.Validators=function(rules){
	Qj.Collection.call(this,rules);
	
	this.Add=function(id,rule,message){
		if(typeof(message)==Qj.Types.Undefined()){
			message="Error!";
		};
		var validator={	Id:id, Rule:rule, Message:message};
		this.Push(validator);
	};
	
};
Qj.Form.Validators.prototype=new Qj.Collection();
Qj.Form.Validators.prototype.constructor=Qj.Form.Validators;



//======================================    UI WIDGETS   =========================================
//Ui Widgets Initializer
Qj.Ui=function(){
	Qj.Tooltip();
	Qj.ProgressBar();
	Qj.Notifycation();
	Qj.Messaging();
	Qj.Editable();
};

//tooltip
Qj.Tooltip=function(){
	if(typeof(Qj.Tooltip.Styles)!=Qj.Types.Object()){
		Qj.Tooltip.Styles={};
	}
	Qj.Select(".qj-tooltip").each(function(){	
		Qj.Select(this).css(Qj.Tooltip.Styles);
		Qj.Select(this).hide();
		var target=Qj.Select(this).parent();
		
		Qj.Select(target).hover(function(e){
			Qj.Select(target).children(".qj-tooltip").stop(true,true)
			.css("top",e.pageY+17)
			.css("left",e.pageX+13)
			.fadeIn(200);
		},function(){
			Qj.Select(target).children(".qj-tooltip").stop(true,true).fadeOut(500);
		});
		Qj.Select(target).mousemove(function(e){
			Qj.Select(target).children(".qj-tooltip").stop(true,true)
			.css("top",e.pageY+17)
			.css("left",e.pageX+13);
		});
	});
	//TODO: stop flickering
};
Qj.Tooltip.Styles=null;

//progress bar
Qj.ProgressBar=function(){
	Qj.Select("div.qj-progress").each(function(){
		var percentage=Qj.Select(this).html();
		Qj.Select(this).html("");
		Qj.Select("<div>"+percentage+"</div>").appendTo(this);	
	});	
};



//notification
Qj.Notifycation=function(){
	if(typeof(Qj.Notifycation.Position)!=Qj.Types.Object()){
		Qj.Notifycation.Position={};
	}
	Qj.Select('<div id="qj-notification-container"></div>')
	.css(Qj.Notifycation.Position)
	.appendTo("body");
};
Qj.Notifycation.Position=null;

Qj.Notifycation.Info=function(){
	return "notification-info";
};
Qj.Notifycation.Success=function(){
	return "notification-success";
};
Qj.Notifycation.Error=function(){
	return "notification-error";
};

Qj.Notifycator=function(message,title,type){
	this.Template='<div id="{id}" class="qj-notification {type}" ><div class="qj-header"><a href="#" class="qj-closebt"></a><h4>{title}</h4></div><p>{message}</p></div>';
	this.Handle=Qj.Id("Notoficator");
	this.Template=this.Template.replace("{id}",this.Handle);
	this.Template=this.Template.replace("{message}",message);
    this.Template=this.Template.replace("{title}",title);
    this.Template=this.Template.replace("{type}",type);  
};
Qj.Notifycator.prototype.Show=function (delay){
	if(delay == Qj.Types.Undefined()){
		delay=0;
	}
    var box=Qj.Select(this.Template).appendTo("div#qj-notification-container").
    fadeOut(0,function(){
    	Qj.Select(this).fadeIn(400);
    });
    var handle=this.Handle;
    
    Qj.Select("div#"+handle+" a.qj-closebt").click(function(){
    	Qj.Select("#"+handle).fadeOut(500,function(){
    		Qj.Select(this).remove();
    	});   	
    });
    if(delay>0){
    	setTimeout(function(){
    		Qj.Select("#"+handle).fadeOut(500,function(){
        		Qj.Select(this).remove();
        	}); 
    	},delay); 	
    }   
};	

//static
Qj.Notifycation.Show=function (message,title,delay,type){
	var notebox=new Qj.Notifycator(message,title,type);
	notebox.Show(delay);
};

//message boxes
Qj.Messaging=function(){
	if(typeof(Qj.MessageBox.Styles)!=Qj.Types.Object()){
		Qj.MessageBox.Styles={};
	}
};
Qj.MessageBox=function(message,title,type){ 
	this.Template='<div id="qj-messagebox-container"><div id="{id}" class="qj-messagebox {type}"><div class="qj-header"><a href="#" class="qj-closebt"></a><h4>{title}</h4></div><p>{message}</p></div></div>';
	this.Handle=Qj.Id("Messagebox");
	this.Template=this.Template.replace("{id}",this.Handle);
	this.Template=this.Template.replace("{message}",message);
    this.Template=this.Template.replace("{title}",title);
    this.Template=this.Template.replace("{type}",type);		
	
};
Qj.MessageBox.Styles=null;

Qj.MessageBox.Info=function(){
	return "messagebox-info";
};
Qj.MessageBox.Warning=function(){
	return "messagebox-warning";
};
Qj.MessageBox.Error=function(){
	return "messagebox-error";
};
Qj.MessageBox.Question=function(){
	return "messagebox-question";
};
Qj.MessageBox.Wait=function(){
	return "messagebox-wait";
};

Qj.MessageBox.prototype.Show= function(){
    Qj.Select(this.Template).css(Qj.MessageBox.Styles).appendTo("body")
    .fadeOut(0,function(){
    	Qj.Select(this).fadeIn(400);
    });
	
	Qj.Select("#"+this.Handle+" a.qj-closebt").click(function(){
    	Qj.Select("#qj-messagebox-container").fadeOut(500,function(){
    		Qj.Select(this).remove();
    	});   	
    });
};

//static Methods
Qj.Messaging.Close=function(){
	Qj.Select("#qj-messagebox-container").fadeOut(500,function(){
		Qj.Select(this).remove();
	});
};

Qj.Messaging.Show=function(message,title,type){
	var msgbox=new Qj.MessageBox(message,title,type);
	msgbox.Show();
};

Qj.Messaging.Wait=function(message,title,delay, fn){	
	Qj.Messaging.Show(message, title, Qj.MessageBox.Wait());
	if(!isNaN(delay)){
		setTimeout(function(){
			Qj.Messaging.Close();
			if(typeof(fn)==Qj.Types.Function()){ 
				fn();
			}
		},delay);
	}
};

Qj.Messaging.Question=function(question,fn){
	var form='<input type="text" size="30" id="qj-messaging-question-input"/><input type="button" id="qj-messaging-question-submit" value="OK" />';
	Qj.Messaging.Show(form, question, Qj.MessageBox.Question());
	
	Qj.Select("#qj-messaging-question-submit").click(function(){
		Qj.Messaging.Close();
		if(typeof(fn)==Qj.Types.Function()){ 
			fn(Qj.Select("#qj-messaging-question-input").val());
		}
	});
};

//iniline editing
Qj.Editable=function(){
	Qj.Editable.InputTemplate='<form><input id="qj-editable-value" /><button id="qj-editable-savebt" >Save</button><button id="qj-editable-cancelbt" >Cancel</button><form>';
	Qj.Editable.TextTemplate='<form><textarea id="qj-editable-value" cols="40" rows="4"></textarea><br/><button id="qj-editable-savebt" >Save</button><button id="qj-editable-cancelbt" >Cancel</button><form>';
	Qj.Editable.Listeners=new Array();
	Qj.Editable.AddListener=function(id,handler){
		if(typeof(handler)==Qj.Types.Function()){
			Qj.Editable.Listeners[id]=handler;
		}
	};
	
	Qj.Select(".qj-editable").each(function(){
		var currentag=this;
		var markup=Qj.Editable.InputTemplate;
		if(Qj.Select(this).hasClass('text')){
			markup=Qj.Editable.TextTemplate;
		}
		var handlerkey=Qj.Select(this).attr("id");
				
		Qj.Select(this).dblclick(function(){
			var previousvalue=Qj.Select(this).html();
			Qj.Select(this).fadeOut(500,function(){
				Qj.Select(this).html(markup).fadeIn(250);
				Qj.Select("#qj-editable-value").focus();
				Qj.Select("#qj-editable-savebt").click(function(){
					var newvalue=Qj.Select("#qj-editable-value").val();
					Qj.Select(currentag).fadeOut(250,function(){
						Qj.Select(currentag).html(newvalue).fadeIn(250);
					});
					if(typeof(Qj.Editable.Listeners[handlerkey])!=Qj.Types.Undefined()){
						Qj.Editable.Listeners[handlerkey](newvalue,true);	
					}
					
				});
				
				Qj.Select("#qj-editable-cancelbt").click(function(){
					Qj.Select(currentag).fadeOut(250,function(){
						Qj.Select(currentag).html(previousvalue).fadeIn(250);
						if(typeof(Qj.Editable.Listeners[handlerkey])!=Qj.Types.Undefined()){
							Qj.Editable.Listeners[handlerkey](previousvalue,false);
						}
					});
				});
			});
		});	
	});	
};
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
