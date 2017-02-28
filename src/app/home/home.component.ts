import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import { FormGroup, FormControl, Validators, FormBuilder }  from '@angular/forms';

import { ToastComponent } from '../shared/toast/toast.component';

import { DataService } from '../services/data.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent {

  label = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cave putes quicquam esse verius. Si mala non sunt, iacet omnis ratio Peripateticorum. At cum de plurimis eadem dicit, tum certe de maximis. Illum mallem levares, quo optimum atque humanissimum virum, Cn. Vide, quantum, inquam, fallare, Torquate. Si quae forte-possumus. Duo Reges: constructio interrete. Itaque hic ipse iam pridem est reiectus; Nam de summo mox, ut dixi, videbimus et ad id explicandum disputationem omnem conferemus. Quare conare, quaeso. Deinde disputat, quod cuiusque generis animantium statui deceat extremum. Non quaeritur autem quid naturae tuae consentaneum sit, sed quid disciplinae. Quid ei reliquisti, nisi te, quoquo modo loqueretur, intellegere, quid diceret?";

  constructor(private http: Http,
              private dataService: DataService,
              public toast: ToastComponent,
              private formBuilder: FormBuilder) { 
  }


}
