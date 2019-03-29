import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NomorPentingPage } from './nomor-penting.page';

describe('NomorPentingPage', () => {
  let component: NomorPentingPage;
  let fixture: ComponentFixture<NomorPentingPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NomorPentingPage ],
      schemas: [CUSTOM_ELEMENTS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NomorPentingPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
