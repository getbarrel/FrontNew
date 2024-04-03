'use strict';

const debug = 0;
const log = (location, message, parameters) => {
	if(debug) console.log(`[${location}] ${message} `, parameters ? parameters : '');
}

const error = (location, message, parameters) => {
	console.error(`[${location}] ${message} `, parameters ? parameters : '');
}

const waring = (location, message, parameters) => {
	console.waring(`[${location}] ${message} `, parameters ? parameters : '');
}

const fbLogger = {
	log: log,
	error: error,
	waring: waring
};

export default fbLogger;