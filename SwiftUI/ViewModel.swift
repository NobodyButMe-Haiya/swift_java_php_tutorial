//
//  ViewModel.swift
//  swiftui_crud
//
//  Created by Hafizan Aziz on 08/08/2021.
//

import Foundation
import SwiftUI
class ViewModel:ObservableObject {
    @Published var items = [DataModel]()
    let prefixUrl = "https://192.168.0.159/SP%20YOUTUBER/php%20base/CRUD/simple_oop_proper.php?"
    
    init(){
        read()
    }
    func create(name:String ,age: Int ) {
        let url = URL(string: prefixUrl)!
        var request = URLRequest(url: url)
        request.httpMethod = "POST"
        
        var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!
        
        components.queryItems = [
            URLQueryItem(name: "name", value: name),
            URLQueryItem(name: "age", value: String(age)),
            URLQueryItem(name: "mode", value: "create")
        ]
        
        let query = components.url!.query
        request.httpBody = Data(query!.utf8)
        URLSession.shared.dataTask(with: url) { (data,res,error) in
            if error != nil {
                
            }
            do {
                if let data = data {
                    let result = try JSONDecoder().decode(CrudModelRead.self, from: data )
                    // we only sync the detail value
                    DispatchQueue.main.async {
                        self.items = result.data
                    }
                }else {
                    print ("No Data")
                }
            }catch let JsonError {
                print ("fetch json error ",JsonError.localizedDescription)
            }
        }
    }
    func read() {
        guard let url = URL(string:prefixUrl+"/read.php") else {
            print("Not found URL")
            return
        }
        URLSession.shared.dataTask(with: url) { (data,res,error) in
            if error != nil {
                
            }
            do {
                if let data = data {
                    let result = try JSONDecoder().decode(CrudModelRead.self, from: data )
                    // we only sync the detail value
                    DispatchQueue.main.async {
                        self.items = result.data
                    }
                }else {
                    print ("No Data")
                }
            }catch let JsonError {
                print ("fetch json error ",JsonError.localizedDescription)
            }
        }
        
    }
    func update(name:String ,age:Int , personId: Int) {
        let url = URL(string: prefixUrl)!
        var request = URLRequest(url: url)
        request.httpMethod = "POST"
        
        var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!
        
        components.queryItems = [
            URLQueryItem(name: "name", value: name),
            URLQueryItem(name: "age", value: String(age)),
            URLQueryItem(name: "personId", value: String(personId)),
            URLQueryItem(name: "mode", value: "update")
        ]
        
        let query = components.url!.query
        request.httpBody = Data(query!.utf8)
        
        URLSession.shared.dataTask(with: request) { (data,res,error) in
            if error != nil {
                
            }
            do {
                if let data = data {
                    let result = try JSONDecoder().decode(CrudModelRead.self, from: data )
                    // we only sync the detail value
                    DispatchQueue.main.async {
                        self.items = result.data
                    }
                }else {
                    print ("No Data")
                }
            }catch let JsonError {
                print ("fetch json error ",JsonError.localizedDescription)
            }
        }
    }
    func delete(personId:Int){
        
        let url = URL(string: prefixUrl)!
        var request = URLRequest(url: url)
        request.httpMethod = "POST"
        
        var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!
        
        components.queryItems = [
            URLQueryItem(name: "personId", value: String(personId)),
            URLQueryItem(name: "mode", value: "delete")
        ]
        
        let query = components.url!.query
        request.httpBody = Data(query!.utf8)
        
        URLSession.shared.dataTask(with: request) { (data,res,error) in
            if error != nil {
                
            }
            do {
                if let data = data {
                    let result = try JSONDecoder().decode(CrudModelRead.self, from: data )
                    // we only sync the detail value
                    DispatchQueue.main.async {
                        self.items = result.data
                    }
                }else {
                    print ("No Data")
                }
            }catch let JsonError {
                print ("fetch json error ",JsonError.localizedDescription)
            }
        }
    }
}
