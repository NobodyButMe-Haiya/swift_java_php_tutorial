//
//  CrudModel.swift
//  swiftui_crud
//
//  Created by Hafizan Aziz on 08/08/2021.
//

import Foundation
import SwiftUI

struct CrudModelRead:Decodable {
    let success:Bool
    let code:Int
    let message:String
    let data:[DataModel]
}
struct DataModel:Decodable {
    let personId:Int
    let name:String
    let age:Int
}

