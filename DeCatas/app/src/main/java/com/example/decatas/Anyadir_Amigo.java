package com.example.decatas;

import android.content.Context;
import android.graphics.Typeface;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.net.MalformedURLException;
import java.util.Arrays;
import java.util.LinkedHashMap;
import java.util.Map;

public class Anyadir_Amigo extends AppCompatActivity {

    private String idUsuario;
    public EditText editUsuario;
    public TableLayout table;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_anyadir__amigo);

        Bundle bundle = getIntent().getExtras();
        this.idUsuario = bundle.getString("id");

        this.editUsuario = (EditText)findViewById(R.id.editTextUsuario);
        this.table = (TableLayout)findViewById(R.id.table);
    }

    public void search(View v) throws MalformedURLException {
        table.removeAllViews();

        String s = editUsuario.getText().toString();

        editUsuario.setBackgroundResource(R.drawable.input_normal);

        editUsuario.setText("");

        closeKeyboard();

        if(s.equals("")){
            Toast.makeText(this, R.string.empty_user, Toast.LENGTH_LONG).show();
            editUsuario.setBackgroundResource(R.drawable.input_error);
        } else {
            Map<String,String> params = new LinkedHashMap<>();
            params.put("s",s);
            params.put("noid",idUsuario);
            Connection c = new Connection(this,"getUsers.php",params);
            while(c.getRes()==null);
            String result = c.getRes();
            if(result.equals("IOException")){
                Toast.makeText(this, R.string.error_connecting, Toast.LENGTH_LONG).show();
            }
            if(result.equals("")){
                Toast.makeText(this, R.string.no_users_found, Toast.LENGTH_LONG).show();
            } else {
                TableRow trTH = new TableRow(this);

                trTH.setGravity(Gravity.CENTER);
                trTH.setBackgroundResource(R.drawable.border);
                trTH.setPadding(10,10,10,10);

                trTH.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                trTH.setVisibility(View.VISIBLE);

                int[] labels = {R.string.name,R.string.user};
                int i=0;

                TextView[] rowTextView1 = new TextView[2];
                for(TextView tv : rowTextView1){
                    tv = new TextView(this);
                    tv.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));
                    tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                    tv.setGravity(Gravity.CENTER);
                    tv.setVisibility(View.VISIBLE);
                    tv.setPadding(10,10,10,10);
                    tv.setTextSize(17);
                    tv.setText(labels[i]);
                    i++;
                    trTH.addView(tv);
                }

                TextView tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10,10,10,10);
                tv.setTextSize(17);
                tv.setText(R.string.add);
                trTH.addView(tv);

                table.addView(trTH);

                String[] amigos = result.split(";");
                for(String a : amigos){
                    String[] infoAmigo = a.split(",");
                    String idU = infoAmigo[0];
                    String usuario = infoAmigo[1];
                    String nombre = infoAmigo[2];

                    TableRow tr = new TableRow(this);

                    tr.setGravity(Gravity.CENTER);
                    tr.setBackgroundResource(R.drawable.border);
                    tr.setPadding(10,10,10,10);

                    tr.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    tr.setVisibility(View.VISIBLE);

                    String[] labels2 = {usuario,nombre};
                    i=0;

                    rowTextView1 = new TextView[2];
                    for(TextView tv2 : rowTextView1){
                        tv2 = new TextView(this);
                        tv2.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.FILL_PARENT,
                                TableRow.LayoutParams.WRAP_CONTENT
                        ));
                        tv2.setGravity(Gravity.CENTER);
                        tv2.setVisibility(View.VISIBLE);
                        tv2.setPadding(10,10,10,10);
                        tv2.setTextSize(17);
                        tv2.setText(labels2[i]);
                        i++;
                        tr.addView(tv2);
                    }

                    ImageButton icon = new ImageButton(this);
                    icon.setBackgroundResource(R.drawable.ic_add_foreground);
                    icon.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));
                    icon.getLayoutParams().height=100;
                    icon.getLayoutParams().width=100;
                    icon.setVisibility(View.VISIBLE);

                    Listener l = new Listener(idU);
                    icon.setOnClickListener(l);

                    tr.addView(icon);

                    table.addView(tr);
                }
            }
        }
    }

    private class Listener implements View.OnClickListener{

        String id;

        public Listener(String i){
            this.id=i;
        }

        @Override
        public void onClick(View v) {
            Map<String,String> params = new LinkedHashMap<>();
            params.put("idUsuario1",idUsuario);
            params.put("idUsuario2",this.id);
            try {
                Connection c = new Connection(getApplicationContext(),"addFriend.php",params);
                while(c.getRes()==null);
                String result = c.getRes();
                if(result.equals("IOException")){
                    OutputStreamWriter outputStreamWriter = null;
                    if(!Arrays.asList(fileList()).contains("requests.txt")) {
                        new File(getFilesDir(), "requests.txt");
                        outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_PRIVATE));
                    }else {
                        outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_APPEND));
                    }
                    outputStreamWriter.write("addFriend.php;"+this.id+"/");
                    outputStreamWriter.close();

                    android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Anyadir_Amigo.this);
                    builder.setCancelable(true);
                    builder.setTitle(R.string.error_connecting);
                    builder.setMessage(R.string.ioexception_message);
                    builder.show();
                } else if(result.equals("1")){
                    Toast.makeText(Anyadir_Amigo.this, R.string.friend_request_sent, Toast.LENGTH_LONG).show();
                }else if(result.equals("0")) {
                    Toast.makeText(Anyadir_Amigo.this, R.string.error_sending_friend_request, Toast.LENGTH_LONG).show();
                } else {
                    Toast.makeText(Anyadir_Amigo.this, R.string.request_repeated, Toast.LENGTH_LONG).show();
                }
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (FileNotFoundException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    private void closeKeyboard(){
        View v = this.getCurrentFocus();
        if(v!=null){
            InputMethodManager imm = (InputMethodManager)getSystemService(Context.INPUT_METHOD_SERVICE);
            imm.hideSoftInputFromWindow(v.getWindowToken(),0);
        }
    }
}