/* eslint-disable */
module.exports = {

  registrationCacheKey: 'data',
  returnCacheKey: 'data',
  initLocalStorage () {
    const storage = $.initNamespaceStorage('registration-local-storage').localStorage;
    return storage;
  },
  initLocalStorage2 () {
    const storage2 = $.initNamespaceStorage('return-local-storage').localStorage;
    return storage2;
  },
  saveInLocalStorage (data) {
    this.initLocalStorage()
      .set(this.registrationCacheKey, data);
  },
  saveInLocalStorage2 (data) {
    this.initLocalStorage2()
      .set(this.returnCacheKey, data);
  },
  getFromLocalStorage () {
    if (!this.initLocalStorage()
        .get(this.registrationCacheKey)) {
      this.reset();
    }
    return this.initLocalStorage()
      .get(this.registrationCacheKey);
  },
  getFromLocalStorage2 () {
    if (!this.initLocalStorage2()
        .get(this.returnCacheKey)) {
      this.reset2();
    }
    return this.initLocalStorage2()
      .get(this.returnCacheKey);
  },
  reset () {
    const data = {
      hasData: false,
      registration: {},
    };

    this.saveInLocalStorage(data);
  },
  reset2 () {
    const data = {
      hasData: false,
      return: {},
    };

    this.saveInLocalStorage2(data);
  },
  getRegistration () {
    const data = this.getFromLocalStorage();
    const registrationData = data.registration;

    return registrationData;
  },
  getReturn () {
    const data = this.getFromLocalStorage2();
    const returnData = data.return;

    return returnData;
  },
  setRegistration (additionalData) {
    const data = this.getFromLocalStorage();
    console.log(data);
    const registrationData = data.registration;

    _.extend(registrationData, additionalData);
    data.registration = registrationData;

    this.saveInLocalStorage(data);
  },
  setReturn (additionalData) {
    const data = this.getFromLocalStorage2();
    console.log(data);
    const returnData = data.return;

    _.extend(returnData, additionalData);
    data.return = returnData;

    this.saveInLocalStorage2(data);
  },
};
