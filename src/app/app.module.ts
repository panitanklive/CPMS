import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms'
import { HttpModule } from '@angular/http';
import { CookieService } from 'ngx-cookie-service';
import { HashLocationStrategy, LocationStrategy } from '@angular/common'
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { NgxPaginationModule } from 'ngx-pagination';
import { Ng2SearchPipeModule } from 'ng2-search-filter';
import { Ng2OrderModule } from 'ng2-order-pipe';
import { UrlService } from './url.service';
import { CalendarModule } from 'angular-calendar';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FullCalendarModule } from 'ng-fullcalendar';
import { NgSelectModule } from '@ng-select/ng-select';
import { AppComponent } from './app.component';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { ReportComponent } from './report/report.component';
import { CarComponent } from './car/car.component';
import { LoginComponent } from './login/login.component';
import { MapComponent } from './map/map.component';
import { AddcarComponent } from './addcar/addcar.component';
import { CalenComponent } from './calen/calen.component';
import { RoundComponent } from './round/round.component';
import { HistoryComponent } from './history/history.component';
import { ContactComponent } from './contact/contact.component';
import { AddtripComponent } from './addtrip/addtrip.component';
import { EditroundComponent } from './editround/editround.component';
import { ViewroundComponent } from './viewround/viewround.component';
import { EditcarComponent } from './editcar/editcar.component';
import { EditmapComponent } from './editmap/editmap.component';
import { ServiceWorkerModule } from '@angular/service-worker';
import { environment } from '../environments/environment';
import { AddmapComponent } from './addmap/addmap.component';

import { GetComponent } from './get/get.component';
import { CheckGuard } from './check.guard';
import { BackCarComponent } from './back-car/back-car.component';
import { Report3Component } from './report3/report3.component';
import { UserComponent } from './user/user.component';
import { EdituserComponent } from './edituser/edituser.component';
import { Report2Component } from './report2/report2.component';

const appRoutes: Routes = [{ path: '', redirectTo: '/car', pathMatch: 'full' },

{ path: 'header', component: HeaderComponent },
{ path: 'car', component: CarComponent },
{ path: 'report', component: ReportComponent, canActivate: [CheckGuard] },
{ path: 'login', component: LoginComponent },
{ path: 'get', component: GetComponent, canActivate: [CheckGuard] },
{ path: 'map', component: MapComponent },
{ path: 'addcar', component: AddcarComponent, canActivate: [CheckGuard] },
{ path: 'addmap', component: AddmapComponent, canActivate: [CheckGuard] },
{ path: 'user', component: UserComponent, canActivate: [CheckGuard] },
{ path: 'edituser/:key', component: EdituserComponent, canActivate: [CheckGuard] },
{ path: 'round', component: RoundComponent },
{ path: 'history', component: HistoryComponent, canActivate: [CheckGuard] },
{ path: 'contact', component: ContactComponent },
{ path: 'addtrip/:key', component: AddtripComponent, canActivate: [CheckGuard] },
{ path: 'editcar/:key', component: EditcarComponent, canActivate: [CheckGuard] },
{ path: 'editround/:key', component: EditroundComponent, canActivate: [CheckGuard] },
{ path: 'viewround/:key', component: ViewroundComponent },
{ path: 'editmap/:key', component: EditmapComponent, canActivate: [CheckGuard] },
{ path: 'back_car/:key/:car', component: BackCarComponent, canActivate: [CheckGuard] },
{ path: 'calendar/:key', component: CalenComponent },
{ path: 'report3', component: Report3Component, canActivate: [CheckGuard] },
{ path: 'report2', component: Report2Component, canActivate: [CheckGuard] },
{ path: '**', redirectTo: '/car' },
];


@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    ReportComponent,
    CarComponent,
    LoginComponent,
    MapComponent,
    AddcarComponent,
    CalenComponent,
    RoundComponent,
    HistoryComponent,
    ContactComponent,
    AddtripComponent,
    EditroundComponent,
    ViewroundComponent,
    EditcarComponent,
    EditmapComponent,
    AddmapComponent,
    GetComponent,
    BackCarComponent,
    Report3Component,
    UserComponent,
    EdituserComponent,
    Report2Component,
  ],
  imports: [
    BrowserModule,
    FormsModule, NgSelectModule,
    Ng2OrderModule,
    NgxPaginationModule,
    Ng2SearchPipeModule,
    HttpModule,
    HttpClientModule,
    BrowserModule,
    FormsModule,
    FullCalendarModule,
    RouterModule.forRoot(
      appRoutes,
      { enableTracing: false }
    ),

    NgbModule.forRoot(),
    BrowserAnimationsModule, CalendarModule.forRoot()
    //BrowserAnimationsModule, CalendarModule.forRoot(), ServiceWorkerModule.register('/carpool/ngsw-worker.js', { enabled: environment.production })
  ],
  providers: [CookieService, UrlService, CheckGuard, { provide: LocationStrategy, useClass: HashLocationStrategy },],

  bootstrap: [AppComponent]
})
export class AppModule { }
