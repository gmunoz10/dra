import { BrowserModule } from '@angular/platform-browser';
import { NgModule, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { Router, RouterModule } from '@angular/router';

import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { SomosComponent } from './somos/somos.component';
import { AgendaComponent } from './agenda/agenda.component';

import { DataService } from './services/data.service';

import { ToastComponent } from './shared/toast/toast.component';

import { StringPipe } from './pipes/string-utils.pipe';


const routing = RouterModule.forRoot([
    { path: '',      component: HomeComponent },
    { path: 'somos', component: SomosComponent },
    { path: 'agenda', component: AgendaComponent }
]);

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    ToastComponent,
    StringPipe,
    SomosComponent,
    AgendaComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    HttpModule,
    routing
  ],
  providers: [
    DataService,
    ToastComponent
  ],
  schemas: [CUSTOM_ELEMENTS_SCHEMA],
  bootstrap: [AppComponent]
  })

export class AppModule {
}
