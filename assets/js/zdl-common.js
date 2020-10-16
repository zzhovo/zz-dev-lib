function ZDL_Locker( on_lock, on_unlock ){
	var locked = false;

	this.lock = function(){
		if( this.is_locked() ){
			throw new Error('already locked');
		}

		locked = true;

		if( jQuery.isFunction( on_lock ) ){
			on_lock();
		}
	};

	this.unlock = function(){
		locked = false;

		if( jQuery.isFunction( on_unlock ) ){
			on_unlock();
		}
	};

	this.is_locked = function(){
		return locked;
	}
}