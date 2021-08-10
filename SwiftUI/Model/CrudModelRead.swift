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
    let data:[DataModel]
}
struct DataModel:Decodable {
    let personId:String
    let name:String
    let age:String
}

