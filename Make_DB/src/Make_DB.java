import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.util.ArrayList;


public class Make_DB {
	public ArrayList<String> get_category() {
		String response = null;
		System.setProperty("http.proxyHost","proxy.sic.shibaura-it.ac.jp");
		System.setProperty("http.proxyPort","10080");

		try {
			// Web APIのリクエストURLを構築する
			String url = "https://app.rakuten.co.jp/services/api/Recipe/CategoryList/20170426?format=xml&elements=categoryId&categoryType=large&applicationId=1097151116895912619";

			// HTTP接続を確立し，処理要求を送る
			HttpURLConnection conn = (HttpURLConnection)(new URL(url)).openConnection();
			conn.setRequestMethod("GET"); // GETメソッド

			// Webサーバからの応答を受け取る
			BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream(),"UTF-8"));
			response = "";
			String line;
			while((line = br.readLine()) != null) {
				response += line;
			}//responseにデータ格納?
			br.close();
			conn.disconnect();
		} catch (IOException ex) {
			ex.printStackTrace();
		}
		ArrayList<String> category_id = new ArrayList<String>();
		// タグで囲まれた文字列を取得して返す
		if (response != null && response.length() > 0) {
			int offset = 0;
			while ((offset = response.indexOf("<", offset)) != -1) {
				if (response.startsWith("<categoryId>", offset)) {
					int end = response.indexOf("</categoryId>", offset);
					category_id.add(response.substring(offset+12, end));
				}
				offset++;
			}
		}
		return category_id;
	}

	public static ArrayList<Recipe> get_rank(String i) {
		String response = null;
		System.setProperty("http.proxyHost","proxy.sic.shibaura-it.ac.jp");
		System.setProperty("http.proxyPort","10080");

		try {

			String url = "https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426?format=xml&categoryId="+ i +"&applicationId=1097151116895912619";


			HttpURLConnection conn = (HttpURLConnection)(new URL(url)).openConnection();
			conn.setRequestMethod("GET");

			BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream(),"UTF-8"));
			response = "";
			String line;
			while((line = br.readLine()) != null) {
				response += line;
			}
			br.close();
			conn.disconnect();
		} catch (IOException ex) {
			ex.printStackTrace();
		}
		ArrayList<Recipe> recipes = new ArrayList<Recipe>();
		Recipe temp_recipe = new Recipe();
		if (response != null && response.length() > 0) {
			int offset = 0;
			/*int offset2 = 0;*/
			int flag = 0;
			while ((offset = response.indexOf("<", offset)) != -1) {//foodimageurl
				if (response.startsWith("<foodImageUrl>", offset)) {
					int end = response.indexOf("</foodImageUrl>", offset);
					temp_recipe.recipe_image_url = response.substring(offset+14, end);
					flag++;
				}
				if (response.startsWith("<recipeMaterial>", offset)) {//recipematerial
					int end = response.indexOf("</recipeIndication>", offset);
					while(response.indexOf("<", offset) != end) {
						if (response.startsWith("<value>", offset)) {
							int end2 = response.indexOf("</value>", offset);
							temp_recipe.recipe_materials.add(response.substring(offset+7, end2));
						}

						offset++;
					}
					flag++;
				}
				/*if (response.startsWith("<recipeIndication>", offset)) {
				int end = response.indexOf("/recipeIndication>", offset);
				temp_recipe.recipe_indication = response.substring(offset+18, end);
				System.out.println(temp_recipe.recipe_indication);
				flag++;
			}*/ //nullになるから消した
			if (response.startsWith("<recipeUrl>", offset)) {//recipeUrl
				int end = response.indexOf("</recipeUrl>", offset);
				temp_recipe.recipe_url = response.substring(offset+11, end);
				flag++;
			}
			if (response.startsWith("<recipeTitle>", offset)) {//recipeTitle
				int end = response.indexOf("</recipeTitle>", offset);
				temp_recipe.recipe_title = response.substring(offset+13, end);
				flag++;
			}
			if(flag == 4) {
				//System.out.println("a");
				flag = 0;
				recipes.add(temp_recipe);
				//System.out.println(recipes.get(recipes.size()-1).recipe_title); どうさcheｃk用
			}
			offset++;

		}
		}
		return recipes;
	}



	// 動作テスト用のmainメソッド
	public static void main(String[] args) throws InterruptedException {
		ArrayList<String> category_id = new ArrayList<String>(); // StringのカテゴリーIDのリスト
		ArrayList<Recipe> recipes = new ArrayList<Recipe>();//レシピクラスのリスト
		int i = 0;
		Make_DB instance = new Make_DB();

		category_id = instance.get_category();//カテゴリーを取得
		while(i < category_id.size()) { //for文でもいい
			System.out.println(category_id.get(i));//動作チェック用
			recipes.addAll(get_rank(category_id.get(i)));//getして切り取る作業
			Thread.sleep(1 * 1000);//ここを消すと動かなくなる
			i++;
		}
		try {
			String url="jdbc:mysql://localhost:3306/cooksample?serverTimezone=JST";
			Class.forName("com.mysql.cj.jdbc.Driver");
			Connection con=DriverManager.getConnection(url,"root","");
			String sql="INSERT INTO recipe VALUES(?,?,?)";
			PreparedStatement prestmt=con.prepareStatement(sql);
		for(int k=0;k<recipes.size();++k) {
		    prestmt.setString(1,recipes.get(k).recipe_url);
		    prestmt.setString(2,recipes.get(k).recipe_image_url);
		    prestmt.setString(3,recipes.get(k).recipe_title);
		    prestmt.executeUpdate();
		}
		    prestmt.close();
		    con.close();
			}catch(Exception e) {
				e.printStackTrace();
			}
		}
		/*for (int k=0; k<recipes.size(); ++k){ //動作チェック
		    System.out.println(recipes.get(k).recipe_url);
		    System.out.println(recipes.get(k).recipe_image_url);
		    System.out.println(recipes.get(k).recipe_title);
		    for(int p=0;p < recipes.get(k).recipe_materials.size();p++) {
		    	System.out.println(recipes.get(k).recipe_materials.get(p));*///recipesっていうリストからゲットしたrecipeクラスの中のrecipe_materialsをgetする
		    }


