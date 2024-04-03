const fbFilters = (targets, filtersOptions) => {
	'use strict';

	const debug = 0;
	const moduleName = 'FB_FILTERS';
	const errorCodes = {
		notAllowSelectorKey: {
			code: 999,
			message: '허용되지 않은 selector key 입니다.',
		},
		notFindElements: {
			code: 999,
			message: '해당 Element를 찾을 수 없습니다.',
		},
		unequalTags: {
			code: 999,
			message: '동일하지 않은 tag가 존재합니다.',
		},
		notAllowedTag: {
			code: 999,
			message: '허용되지 않는 태그 입니다.'
		}
	}

	/*
		tag options
		tag: {
			tagName: {
			type: {
				event: string,
				isMultiple: boolean,
				setValueType: datatype,
				setAttribute: string,
				getAttribute: string,
			}
			}
		},
		event: function
	*/
	let options = {
		tag: {
			input: {
				checkbox: {
					event: 'change',
					isMultiple: true,
					setValueType: Boolean,
					setAttribute: 'checked',
					getAttribute: 'checked',
				},
				radio: {
					event: 'change',
					isMultiple: false,
					setValueType: Boolean,
					setAttribute: 'checked',
					getAttribute: 'value',
				},
				text: {
					event: 'change',
					isMultiple: true,
					setValueType: String,
					setAttribute: 'value',
					getAttribute: 'value',
				},
				date: {
					event: 'blur',
					isMultiple: true,
					setValueType: String,
					setAttribute: 'value',
					getAttribute: 'value',
				},
				tel: {
					event: 'change',
					isMultiple: true,
					setValueType: String,
					setAttribute: 'value',
					getAttribute: 'value',
				}
			},
			select: {
				'select-one': {
					event: 'change',
					isMultiple: true,
					setValueType: String,
					setAttribute: 'value',
					getAttribute: 'value',
				}
			}
		},
		event: null
	};
	let filters = {};

	/*
		[{
			selector: {
			name: 'fat_filter_view_counting'
			},
			key: 'viewCounting'
		}, {
			selector: {
			id: 'fat_conrtol_filter_start_date'
			},
			key: 'startDate'
		}, {
			selector: {
			id: 'fat_conrtol_filter_end_date'
			},
			key: 'endDate'
		}, {
			selector: {
			name: 'fat_filter_counting_screen'
			},
			key: 'countingScreen'
		}, {
			selector: {
			name: 'fat_filter_counting_system'
			},
			key: 'countingSystem'
		}];
	*/

	const log = (message, parameters) => {
		if(debug) console.log(`[ ${moduleName} ] ${message} `, (parameters || ''));
	}

	const validationFilterElements = (elements) => {
		const firstElement = elements[0];
		const firstElementTagName = firstElement.tagName;
		const isSameTag = elements.every(v => firstElementTagName === v.tagName);

		return isSameTag;
	}

	const setElementsAttribute = (property, attribute, value) => {
		log('setValue', {property, value});
		
		const target = filters[property];

		if(undefined === target) return false;

		for(let element of target.elements) {
			element[attribute] = value;
		}

		return true;
	}

	const setValue = (property, value) => {
		log('setValue', {property, value});
		
		const target = filters[property];

		if(undefined === target) return false;
		if(target.allowValues && target.allowValues.length && !target.allowValues.includes(value)) return false;

		const elements = target.elements;
		const tagOption = target.tagOption;
		
		if(tagOption.isMultiple) {
			for(let element of elements) {
				element[tagOption.setAttribute] = Boolean === tagOption.setValueType ? !!value : value;
			}
		}
		else {
			const targetElement = elements.find(v => value === v.value);
			
			if (targetElement) targetElement[tagOption.setAttribute] = Boolean === tagOption.setValueType ? !!value : value;
			else return false;
		}

		target.value = value;

		return true;
	}

	const getElements = (selector) => {
		let elements = null;

		for(let [key, value] of Object.entries(selector)) {
			let targets = null;

			switch(key) {
				case 'class':
					targets = document.getElementsByClassName(value);
				break;
				case 'id':
					targets = [ document.getElementById(value) ];
				break;
				case 'name':
					targets = document.getElementsByName(value);
				break;
				case 'querySelector':
					targets = [ document.querySelector(value) ];
				break;
				case 'querySelectorAll':
					targets = document.querySelectorAll(value);
				break;
				default:
					throw(errorCodes.notAllowSelectorKey);
				}

				if(targets[0]) {
				if(isNodeList(targets)) targets = Array.prototype.slice.call(targets);
				if(isHTMLCollection(targets)) targets = Array.prototype.slice.call(targets);

				elements = targets;
			}
		}

		return elements;
	};

	const getTagOptions = (element) => {
		const tagName = element.tagName.toLowerCase();
		const type = element.type;

		return tagName && type ? options.tag[tagName][type] : null;
	}

	const getAllowValues = (elements) => {
		const verificationElement = elements[0];
		let allowValues = null;

		switch(verificationElement.type) {
			case 'checkbox':
				allowValues = [true, false];
			break;
			case 'radio':
				const tagOption = getTagOptions(verificationElement);

				allowValues = elements.map(v => v[tagOption.getAttribute]);
			break;
		}

		return allowValues;
	}

	const getValue = (property) => {
		const isProperty = filters.hasOwnProperty(property);

		return isProperty ? filters[property].value : null;
	}

	const getFilters = () => {
		const result = {};

		for(let [key, value] of Object.entries(filters)) {
			result[key] = value.value;
		}

		return result;
	}

	/*
		https://gist.github.com/ahtcx/0cd94e62691f539160b32ecda18af3d6
		Merge a `source` object to a `target` recursively
	*/
	const merge = (target, source) => {
		// Iterate through `source` properties and if an `Object` set property to merge of `target` and `source` properties
		for (let key of Object.keys(source)) {
			if (source[key] instanceof Object) Object.assign(source[key], merge(target[key], source[key]));
		}

		// Join `target` and modified `source`
		Object.assign(target || {}, source);
		return target;
	}

	const isNodeList = (elements) => {
		log('isNodeList', { elements, isNodeList: NodeList.prototype.isPrototypeOf(elements) });

		return NodeList.prototype.isPrototypeOf(elements);
	}

	const isHTMLCollection = (elements) => {
		log('isHTMLCollection', { elements, isHTMLCollection: HTMLCollection.prototype.isPrototypeOf(elements) });

		return HTMLCollection.prototype.isPrototypeOf(elements);
	}

	const addFilters = (targets) => {
		if(targets instanceof Array) {
			for(let target of targets) {
				addFilter(target);
			}
		}
		else {
			throw('addFilters targets error');
		}	
	}

   const addFilter = (target) => {
		const elements = getElements(target.selector);

		if(!elements || !elements.length) throw(errorCodes.notFindElements);
		if(validationFilterElements(elements)) {
			const tagOption = getTagOptions(elements[0]);
			if(!tagOption) throw(errorCodes.notAllowedTag);

			const filter = {
				elements,
				tagOption,
				allowValues: getAllowValues(elements, tagOption),
				value: null,
				event: filterEvent.bind(null, target, tagOption)
			};

			for(let element of elements) {
				if(tagOption.setAttribute && element[tagOption.setAttribute]) filter.value = element[tagOption.getAttribute];

				element.addEventListener(tagOption.event, filter.event);
			}

			filters[target.key] = filter;
		}
		else {
			throw(errorCodes.unequalTags);
		}
   }

   const removeFilter = (property) => {
		const filter = filters[property];

		if(filter) {
			removeFilterEvent(filter);

			return delete filters[property];
		}
		else {
			return false;
		}
   }

   const removeFilterEvent = (filter) => {
		const elements = filter.elements;
		const tagOption = getTagOptions(elements[0]);

		for(let element of elements) {
			element.removeEventListener(tagOption.event, filter.event);
		}
   }

   const filterEvent = (target, tagOption, event) => {
		event.stopPropagation();
		
		const value = event.target[tagOption.getAttribute];

		filters[target.key].value = value;
		
		if(options.event) options.event(event, target.key, value);
   }

   const dispose = () => {
		for(let [key, value] of Object.entries(filters)) {
			removeFilterEvent(filters[key]);
		}

		options = null;
		filters = null;
   }

   const initializationFilters = targets => {
		log('initializationFilters', { targets, filters});
	
		addFilters(targets);
   }

   //
   //
   if(filtersOptions) merge(options, filtersOptions);

   initializationFilters(targets);

   return {
		dispose: dispose,

		addFilters: addFilters,
		addFilter: addFilter,
		removeFilter: removeFilter,

		setElementsAttribute: setElementsAttribute,
		setValue: setValue,
		getValue: getValue,
		getFilters: getFilters,
   }
};

export default fbFilters;