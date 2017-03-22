import { Component } from '@angular/core';

@Component({
  selector: 'app-about',
  templateUrl: './about.component.html',
  styleUrls: ['./about.component.css']
})
export class AboutComponent {

   edad: String;

  constructor() { 
  	this.imprimir();
  	this.edad = "12";
  }

  imprimir() {

  }

}
