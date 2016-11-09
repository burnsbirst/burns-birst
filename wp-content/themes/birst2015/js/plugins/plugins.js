/* jshint ignore:start */
// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  arguments.callee = arguments.callee.caller;
  if(this.console) console.log( Array.prototype.slice.call(arguments) );
};
// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();)b[a]=b[a]||c;})(window.console=window.console||{});
/* jshint: ignore:end */

// bootstrap-transitions.min.js
//= bootstrap-transitions.min.js

// bootstrap-collapse.min.js
//= bootstrap-collapse.min.js

// jquery.columnizer.min.js
//= jquery.columnizer.min.js

// jquery.smint.min.js
//= jquery.smint.min.js

// select2.min.js
//= select2.min.js

// jquery.equalheights.min.js
//= jquery.equalheights.min.js

// jquery.countdown.min.js
//= jquery.countdown.min.js