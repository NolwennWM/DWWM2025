"use strict";
document.chaussette;
// Pour utiliser une interface, on utilisera "implements"
class Point3D {
    x = 0;
    y = 1;
    z = 2;
    get() {
        return this.x;
    }
}
function show(p) { }
show(new Point3D());
