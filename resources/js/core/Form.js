import Errors from './Errors';

class Form {

	constructor(data) {

		this.originalData = JSON.parse(JSON.stringify(data));

		Object.assign(this, data);

		this.errors = new Errors();

	}

	data() {

		let data = {};

		for( let field in this.originalData) {

			data[field] = this[field];
		}

		return data;

	}

	reset() {

		for (let field in this.originalData) {
			this[field] = this.originalData[field];
		}

		this.errors.clear();
	}

		
	post(endpoint) {
		return this.submit(endpoint);
	}


	patch(endpoint) {

		return this.submit(endpoint, requestType = 'patch');

	}
	delete(endpoint) {

		return this.submit(endpoint, requestType = 'patch');
		
	}

	submit(endpoint, requestType = 'post') {
			return axios[requestType](endpoint, this.data())
				.then(this.onSuccess.bind(this))
				.catch(this.onFail.bind(this));			
	}

	onSuccess(response) {
		return response;
	}

	onFail(error) {
 		this.errors.record(error.response.data.errors);
 		throw error;
	}	

}

export default Form;