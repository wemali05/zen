const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"resources.index":{"uri":"resources","methods":["GET","HEAD"]},"resources.create":{"uri":"resources\/create","methods":["GET","HEAD"]},"resources.store":{"uri":"resources","methods":["POST"]},"resources.show":{"uri":"resources\/{resource}","methods":["GET","HEAD"],"bindings":{"resource":"id"}},"resources.edit":{"uri":"resources\/{resource}\/edit","methods":["GET","HEAD"],"bindings":{"resource":"id"}},"resources.update":{"uri":"resources\/{resource}","methods":["PUT","PATCH"],"bindings":{"resource":"id"}},"resources.destroy":{"uri":"resources\/{resource}","methods":["DELETE"],"bindings":{"resource":"id"}}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
