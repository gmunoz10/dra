import { BrowserModule } from '@angular/platform-browser';
import { NgModule, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { Router, RouterModule } from '@angular/router';

import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { SomosComponent } from './somos/somos.component';
import { AgendaComponent } from './agenda/agenda.component';
import { GaleriaComponent } from './galeria/galeria.component';
import { VisionMisionComponent } from './vision-mision/vision-mision.component';
import { TemasAgrariosComponent } from './temas-agrarios/temas-agrarios.component';
import { DireccionOficinaComponent } from './direccion-oficina/direccion-oficina.component';
import { AgenciaAgrariaComponent } from './agencia-agraria/agencia-agraria.component';
import { ContactoComponent } from './contacto/contacto.component';
import { TransparenciaComponent } from './transparencia/transparencia.component';

import { DataService } from './services/data.service';

import { ToastComponent } from './shared/toast/toast.component';

import { StringPipe } from './pipes/string-utils.pipe';



const routing = RouterModule.forRoot([
    { path: '',      component: HomeComponent },
    { path: 'somos', component: SomosComponent },
    { path: 'agenda', component: AgendaComponent },
    { path: 'galeria', component: GaleriaComponent },
    { path: 'vision-mision', component: VisionMisionComponent },
    { path: 'temas-agrarios', component: TemasAgrariosComponent },
    { path: 'direccion-oficina', component: DireccionOficinaComponent },
    { path: 'agencias-agrarias', component: AgenciaAgrariaComponent },
    { path: 'contacto', component: ContactoComponent },
    { path: 'transparencia', component: TransparenciaComponent }
]);

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    ToastComponent,
    StringPipe,
    SomosComponent,
    AgendaComponent,
    GaleriaComponent,
    VisionMisionComponent,
    TemasAgrariosComponent,
    DireccionOficinaComponent,
    AgenciaAgrariaComponent,
    ContactoComponent,
    TransparenciaComponent
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
