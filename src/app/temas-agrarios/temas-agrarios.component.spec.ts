/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { DebugElement } from '@angular/core';

import { TemasAgrariosComponent } from './temas-agrarios.component';

describe('TemasAgrariosComponent', () => {
  let component: TemasAgrariosComponent;
  let fixture: ComponentFixture<TemasAgrariosComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TemasAgrariosComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TemasAgrariosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
