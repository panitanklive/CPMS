import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { UrlService } from './url.service';

@Injectable({
  providedIn: 'root'
})
export class CheckGuard implements CanActivate {
  constructor(private router: Router, public service: UrlService) { }
  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {
    let peet = false
    if (this.service.gc == "") {
      this.router.navigate([''])
      peet = false
    } else {
      peet = true
    }
    return peet;
  }
}
