FasdUAS 1.101.10   ��   ��    k             l    
 ����  r     
  	  J      
 
     m        �   
 A d i u m      m       �   $ A p p l e S c r i p t   E d i t o r      m       �    F i n d e r      m       �    Q u i c k s i l v e r      m       �    T e r m i n a l   ��  m         � ! !  T w e e t b o t��   	 o      ���� 0 	blacklist 	blackList��  ��     " # " l    $���� $ r     % & % J     ' '  ( ) ( m     * * � + +  p o s t b o x - b i n )  , - , m     . . � / /  j i r a c l i e n t -  0�� 0 m     1 1 � 2 2  w e b i d e��   & o      ���� 0 	javanames 	javaNames��  ��   #  3 4 3 l    5���� 5 r     6 7 6 J     8 8  9 : 9 m     ; ; � < <  P o s t b o x :  = > = m     ? ? � @ @  J I R A   C l i e n t >  A�� A m     B B � C C  P h p S t o r m��   7 o      ���� 0 	realnames 	realNames��  ��   4  D E D l     ��������  ��  ��   E  F G F l   � H���� H O    � I J I X   ! � K�� L K Q   9 � M N�� M Z   < � O P���� O =  < C Q R Q n   < A S T S 1   = A��
�� 
bkgo T o   < =���� 0 proc   R m   A B��
�� boovfals P Q   F � U V�� U k   I � W W  X Y X r   I R Z [ Z l  I N \���� \ n   I N ] ^ ] 1   J N��
�� 
pnam ^ o   I J���� 0 proc  ��  ��   [ o      ���� 0 procname procName Y  _ ` _ l  S S��������  ��  ��   `  a b a Z   S � c d���� c E   S X e f e o   S T���� 0 	javanames 	javaNames f o   T W���� 0 procname procName d Y   [ � g�� h i�� g Z   i � j k���� j =  i s l m l n   i o n o n 4   j o�� p
�� 
cobj p o   m n���� 0 i   o o   i j���� 0 	javanames 	javaNames m o   o r���� 0 procname procName k k   v � q q  r s r r   v � t u t l  v | v���� v n   v | w x w 4   w |�� y
�� 
cobj y o   z {���� 0 i   x o   v w���� 0 	realnames 	realNames��  ��   u o      ���� 0 procname procName s  z�� z  S   � ���  ��  ��  �� 0 i   h m   ^ _����  i l  _ d {���� { I  _ d�� |��
�� .corecnte****       **** | o   _ `���� 0 	javanames 	javaNames��  ��  ��  ��  ��  ��   b  } ~ } l  � ���������  ��  ��   ~  ��  Z   � � � ����� � H   � � � � E   � � � � � o   � ����� 0 	blacklist 	blackList � o   � ����� 0 procname procName � n  � � � � � I   � ��� ����� 0 setfullscreen setFullScreen �  � � � o   � ����� 0 procname procName �  � � � m   � �����   �  ��� � m   � ���
�� boovtrue��  ��   �  f   � ���  ��  ��   V R      ������
�� .ascrerr ****      � ****��  ��  ��  ��  ��   N R      ������
�� .ascrerr ****      � ****��  ��  ��  �� 0 proc   L 2   $ )��
�� 
prcs J m     � ��                                                                                  sevs  alis    �  Macintosh HD               ���PH+   C�System Events.app                                               GP��Y        ����  	                CoreServices    ��G�      ���     C� C� C�  =Macintosh HD:System: Library: CoreServices: System Events.app   $  S y s t e m   E v e n t s . a p p    M a c i n t o s h   H D  -System/Library/CoreServices/System Events.app   / ��  ��  ��   G  � � � l     ��������  ��  ��   �  � � � l      �� � ���   �OI
Sets the fullscreen status for either the front window or all windows of the specified application.
The 2nd parameter can take the following values:
 0 � turn fullscreen OFF
 1 � turn fullscreen ON
 2 � toggle fullscreen

Example:
  my setFullScreen("Safari", 2, false) toggles fullscreen status of Safari's front window. 

NOTE:
    - The targeted application is also activated (also required for technical reasons).
    - If you target *all* windows of an application, this subroutine will activate them one by one, which
      is required for technical reasons, unfortunately.
      This means: Whenever you target *all* windows, expect a lot of visual activity, even when 
      the fullscreen status needs no changing; activity is prolonged when fullscreen transitions
      are involved.
     - If the target application has a mix of fullscreen and non-fullscreen windows and the application
      is not currently frontmost, the OS considers the first *non*-fullscreen window to
      be the front one, even if a fullscreen window was active when the application was
      last frontmost.
    � � � �� 
 S e t s   t h e   f u l l s c r e e n   s t a t u s   f o r   e i t h e r   t h e   f r o n t   w i n d o w   o r   a l l   w i n d o w s   o f   t h e   s p e c i f i e d   a p p l i c a t i o n . 
 T h e   2 n d   p a r a m e t e r   c a n   t a k e   t h e   f o l l o w i n g   v a l u e s : 
   0   &   t u r n   f u l l s c r e e n   O F F 
   1   &   t u r n   f u l l s c r e e n   O N 
   2   &   t o g g l e   f u l l s c r e e n 
 
 E x a m p l e : 
     m y   s e t F u l l S c r e e n ( " S a f a r i " ,   2 ,   f a l s e )   t o g g l e s   f u l l s c r e e n   s t a t u s   o f   S a f a r i ' s   f r o n t   w i n d o w .   
 
 N O T E : 
         -   T h e   t a r g e t e d   a p p l i c a t i o n   i s   a l s o   a c t i v a t e d   ( a l s o   r e q u i r e d   f o r   t e c h n i c a l   r e a s o n s ) . 
         -   I f   y o u   t a r g e t   * a l l *   w i n d o w s   o f   a n   a p p l i c a t i o n ,   t h i s   s u b r o u t i n e   w i l l   a c t i v a t e   t h e m   o n e   b y   o n e ,   w h i c h 
             i s   r e q u i r e d   f o r   t e c h n i c a l   r e a s o n s ,   u n f o r t u n a t e l y . 
             T h i s   m e a n s :   W h e n e v e r   y o u   t a r g e t   * a l l *   w i n d o w s ,   e x p e c t   a   l o t   o f   v i s u a l   a c t i v i t y ,   e v e n   w h e n   
             t h e   f u l l s c r e e n   s t a t u s   n e e d s   n o   c h a n g i n g ;   a c t i v i t y   i s   p r o l o n g e d   w h e n   f u l l s c r e e n   t r a n s i t i o n s 
             a r e   i n v o l v e d . 
           -   I f   t h e   t a r g e t   a p p l i c a t i o n   h a s   a   m i x   o f   f u l l s c r e e n   a n d   n o n - f u l l s c r e e n   w i n d o w s   a n d   t h e   a p p l i c a t i o n 
             i s   n o t   c u r r e n t l y   f r o n t m o s t ,   t h e   O S   c o n s i d e r s   t h e   f i r s t   * n o n * - f u l l s c r e e n   w i n d o w   t o 
             b e   t h e   f r o n t   o n e ,   e v e n   i f   a   f u l l s c r e e n   w i n d o w   w a s   a c t i v e   w h e n   t h e   a p p l i c a t i o n   w a s 
             l a s t   f r o n t m o s t . 
 �  ��� � i      � � � I      �� ����� 0 setfullscreen setFullScreen �  � � � o      ���� 0 appname appName �  � � � o      ���� @0 zeroforoffoneforontwofortoggle zeroForOffOneForOnTwoForToggle �  ��� � o      ���� 0 
allwindows 
allWindows��  ��   � k    9 � �  � � � l     ��������  ��  ��   �  � � � l     �� � ���   � !  Get window list and count.    � � � � 6   G e t   w i n d o w   l i s t   a n d   c o u n t . �  � � � O       � � � k     � �  � � � r     � � � 6    � � � 2   
��
�� 
cwin � =    � � � 1    ��
�� 
pvis � m    ��
�� boovtrue � o      ���� 0 	wapp_list   �  � � � r     � � � I   �� ���
�� .corecnte****       **** � o    ���� 0 	wapp_list  ��   � o      ���� 
0 wcount   �  � � � l   �� � ���   � ? 9# set wapp_names to name of windows whose visible is true    � � � � r #   s e t   w a p p _ n a m e s   t o   n a m e   o f   w i n d o w s   w h o s e   v i s i b l e   i s   t r u e �  ��� � l   �� � ���   �  # log wapp_names    � � � �   #   l o g   w a p p _ n a m e s��   � 4     �� �
�� 
capp � o    ���� 0 appname appName �  � � � l  ! !��������  ��  ��   �  � � � l  ! $ � � � � r   ! $ � � � m   ! "����  � o      ���� 0 	max_tries 	MAX_TRIES � E ? Max. number of attempts to obtain the relevant process window.    � � � � ~   M a x .   n u m b e r   o f   a t t e m p t s   t o   o b t a i n   t h e   r e l e v a n t   p r o c e s s   w i n d o w . �  � � � l  % %��������  ��  ��   �  � � � r   % * � � � =  % ( � � � o   % &���� @0 zeroforoffoneforontwofortoggle zeroForOffOneForOnTwoForToggle � m   & '����  � o      ���� 
0 toggle   �  � � � r   + . � � � m   + ,��
�� boovfals � o      ���� 0 turnon turnOn �  � � � Z  / = � ����� � H   / 1 � � o   / 0���� 
0 toggle   � r   4 9 � � � =  4 7 � � � o   4 5���� @0 zeroforoffoneforontwofortoggle zeroForOffOneForOnTwoForToggle � m   5 6����  � o      ���� 0 turnon turnOn��  ��   �  � � � l  > >����~��  �  �~   �  ��} � Z   >9 � � ��| � F   > G � � � o   > ?�{�{ 0 
allwindows 
allWindows � ?   B E � � � o   B C�z�z 
0 wcount   � m   C D�y�y  � l  J� � � � � O   J� � � � O   N� � � � k   U� � �  � � � r   U X � � � m   U V�x�x�� � o      �w�w *0 indexoftruefrontwin indexOfTrueFrontWin �  � � � r   Y \ � � � m   Y Z�v
�v 
msng � o      �u�u 0 wproc_target   �  � � � r   ] ` � � � m   ] ^�t
�t 
msng � o      �s�s $0 wproc_targetname wproc_targetName �  �  � l  a a�r�r   %  Loop over application windows:    � >   L o o p   o v e r   a p p l i c a t i o n   w i n d o w s :   l  a a�q�q   , & Note that we have 2 extra iterations:    � L   N o t e   t h a t   w e   h a v e   2   e x t r a   i t e r a t i o n s : 	
	 l  a a�p�p   u o  Index 0 to determine the index of the true front window, and count + 1 to process the true front window last.    � �     I n d e x   0   t o   d e t e r m i n e   t h e   i n d e x   o f   t h e   t r u e   f r o n t   w i n d o w ,   a n d   c o u n t   +   1   t o   p r o c e s s   t h e   t r u e   f r o n t   w i n d o w   l a s t .
 �o Y   a��n�m k   m�  l  m m�l�l    # log "iteration " & i    � , #   l o g   " i t e r a t i o n   "   &   i �k Z   m��j F   m x >   m p o   m n�i�i 0 i   m   n o�h�h   =   s v !  o   s t�g�g 0 i  ! o   t u�f�f *0 indexoftruefrontwin indexOfTrueFrontWin l  { {�e"#�e  " 3 -# log "ignoring true front win for now: " & i   # �$$ Z #   l o g   " i g n o r i n g   t r u e   f r o n t   w i n   f o r   n o w :   "   &   i�j   k   �%% &'& r    �()( m    ��d
�d boovfals) o      �c�c 0 ok  ' *+* Z   � �,-�b�a, >   � �./. o   � ��`�` 0 i  / m   � ��_�_  - k   � �00 121 r   � �343 o   � ��^�^ 0 i  4 o      �]�] 0 
wapp_index  2 565 Z  � �78�\�[7 =   � �9:9 o   � ��Z�Z 0 i  : [   � �;<; o   � ��Y�Y 
0 wcount  < m   � ��X�X 8 r   � �=>= o   � ��W�W *0 indexoftruefrontwin indexOfTrueFrontWin> o      �V�V 0 
wapp_index  �\  �[  6 ?@? r   � �ABA e   � �CC n   � �DED 4   � ��UF
�U 
cobjF o   � ��T�T 0 
wapp_index  E o   � ��S�S 0 	wapp_list  B o      �R�R 0 wapp_target  @ G�QG l  � �HIJH r   � �KLK e   � �MM n   � �NON 1   � ��P
�P 
pnamO o   � ��O�O 0 wapp_target  L o      �N�N "0 wapp_targetname wapp_targetNameI W Q Note: We get the name up front, as accessing the property below sometimes fails.   J �PP �   N o t e :   W e   g e t   t h e   n a m e   u p   f r o n t ,   a s   a c c e s s i n g   t h e   p r o p e r t y   b e l o w   s o m e t i m e s   f a i l s .�Q  �b  �a  + QRQ Y   ��S�MTU�LS k   ��VV WXW l  � ��KYZ�K  Y [ U# log "looking for #" & i & ": [" & wapp_targetName & "] (" & id of wapp_target & ")"   Z �[[ � #   l o g   " l o o k i n g   f o r   # "   &   i   &   " :   [ "   &   w a p p _ t a r g e t N a m e   &   " ]   ( "   &   i d   o f   w a p p _ t a r g e t   &   " ) "X \]\ l  � ��J^_�J  ^ p j NOTE: We MUST activate the application and the specific window in case that window is in fullscreen mode.   _ �`` �   N O T E :   W e   M U S T   a c t i v a t e   t h e   a p p l i c a t i o n   a n d   t h e   s p e c i f i c   w i n d o w   i n   c a s e   t h a t   w i n d o w   i s   i n   f u l l s c r e e n   m o d e .] aba l  � ��Icd�I  c u o        Bizzarrely, without activating both, we would not gain access to that active window's *process* window,   d �ee �                 B i z z a r r e l y ,   w i t h o u t   a c t i v a t i n g   b o t h ,   w e   w o u l d   n o t   g a i n   a c c e s s   t o   t h a t   a c t i v e   w i n d o w ' s   * p r o c e s s *   w i n d o w ,b fgf l  � ��Hhi�H  h D >        which we need to examine and change fullscreen status.   i �jj |                 w h i c h   w e   n e e d   t o   e x a m i n e   a n d   c h a n g e   f u l l s c r e e n   s t a t u s .g klk Z   � �mn�G�Fm >   � �opo o   � ��E�E 0 i  p m   � ��D�D  n k   � �qq rsr l  � ��Ctu�C  t 5 /# log "making front window: " & wapp_targetName   u �vv ^ #   l o g   " m a k i n g   f r o n t   w i n d o w :   "   &   w a p p _ t a r g e t N a m es w�Bw l  � �xyzx r   � �{|{ m   � ��A�A | n      }~} 1   � ��@
�@ 
pidx~ o   � ��?�? 0 wapp_target  y � � Make the window the front (active) one; we try this *repeatedly*, as it can get ignored if a switch from a previous window hasn't completed yet.   z �"   M a k e   t h e   w i n d o w   t h e   f r o n t   ( a c t i v e )   o n e ;   w e   t r y   t h i s   * r e p e a t e d l y * ,   a s   i t   c a n   g e t   i g n o r e d   i f   a   s w i t c h   f r o m   a   p r e v i o u s   w i n d o w   h a s n ' t   c o m p l e t e d   y e t .�B  �G  �F  l ��� l  � ����� r   � ���� m   � ��>
�> boovtrue� 1   � ��=
�= 
pisf� Z T Activate the application; we also do this repeatedly in the interest of robustness.   � ��� �   A c t i v a t e   t h e   a p p l i c a t i o n ;   w e   a l s o   d o   t h i s   r e p e a t e d l y   i n   t h e   i n t e r e s t   o f   r o b u s t n e s s .� ��� l  � ����� I  � ��<��;
�< .sysodelanull��� ��� nmbr� m   � ��� ?ə������;  � � � Note: Only when the window at hand is currently in fullscreen mode are several iterations needed - presumably, because switching to that window's space takes time.   � ���H   N o t e :   O n l y   w h e n   t h e   w i n d o w   a t   h a n d   i s   c u r r e n t l y   i n   f u l l s c r e e n   m o d e   a r e   s e v e r a l   i t e r a t i o n s   n e e d e d   -   p r e s u m a b l y ,   b e c a u s e   s w i t c h i n g   t o   t h a t   w i n d o w ' s   s p a c e   t a k e s   t i m e .� ��:� Q   �����9� k   �~�� ��� l  � ��8���8  � 4 . Obtain the same window as a *process* window.   � ��� \   O b t a i n   t h e   s a m e   w i n d o w   a s   a   * p r o c e s s *   w i n d o w .� ��� l  � ��7���7  � O I Note: This can fail before switching to a fullscreen window is complete.   � ��� �   N o t e :   T h i s   c a n   f a i l   b e f o r e   s w i t c h i n g   t o   a   f u l l s c r e e n   w i n d o w   i s   c o m p l e t e .� ��� r   � ���� 4  � ��6�
�6 
cwin� m   � ��5�5 � o      �4�4 0 wproc_current  � ��� l  � ��3���3  � 7 1 See if the desired process window is now active.   � ��� b   S e e   i f   t h e   d e s i r e d   p r o c e s s   w i n d o w   i s   n o w   a c t i v e .� ��� l  � ��2���2  � p j Note that at this point a previous, fullscreen window may still be reported as the active one, so we must   � ��� �   N o t e   t h a t   a t   t h i s   p o i n t   a   p r e v i o u s ,   f u l l s c r e e n   w i n d o w   m a y   s t i l l   b e   r e p o r t e d   a s   t h e   a c t i v e   o n e ,   s o   w e   m u s t� ��� l  � ��1���1  � L F test whether the process window just obtained it is the desired one.    � ��� �   t e s t   w h e t h e r   t h e   p r o c e s s   w i n d o w   j u s t   o b t a i n e d   i t   i s   t h e   d e s i r e d   o n e .  � ��� l  � ��0���0  � \ V We test by *name* (window title), as that is the only property that the *application*   � ��� �   W e   t e s t   b y   * n a m e *   ( w i n d o w   t i t l e ) ,   a s   t h a t   i s   t h e   o n l y   p r o p e r t y   t h a t   t h e   * a p p l i c a t i o n *� ��� l  � ��/���/  � d ^ window class and the *process* window class (directly) share; sadly, only application windows   � ��� �   w i n d o w   c l a s s   a n d   t h e   * p r o c e s s *   w i n d o w   c l a s s   ( d i r e c t l y )   s h a r e ;   s a d l y ,   o n l y   a p p l i c a t i o n   w i n d o w s� ��� l  � ��.���.  �   have an 'id' property.   � ��� .   h a v e   a n   ' i d '   p r o p e r t y .� ��� l  � ��-���-  � ` Z (There is potential for making this more robust, though, by also comparing window sizes.)   � ��� �   ( T h e r e   i s   p o t e n t i a l   f o r   m a k i n g   t h i s   m o r e   r o b u s t ,   t h o u g h ,   b y   a l s o   c o m p a r i n g   w i n d o w   s i z e s . )� ��,� Z   �~���+�� =   � ���� o   � ��*�* 0 i  � m   � ��)�)  � k   ��� ��� l  � ��(���(  � W Q We determine the index of the *actual* front window, so we can process it *last*   � ��� �   W e   d e t e r m i n e   t h e   i n d e x   o f   t h e   * a c t u a l *   f r o n t   w i n d o w ,   s o   w e   c a n   p r o c e s s   i t   * l a s t *� ��� l  � ��'���'  � Z T so we return to the same window that was originally active; with fullscreen windows   � ��� �   s o   w e   r e t u r n   t o   t h e   s a m e   w i n d o w   t h a t   w a s   o r i g i n a l l y   a c t i v e ;   w i t h   f u l l s c r e e n   w i n d o w s� ��� l  � ��&���&  � L F involved, sadly, `front window` is NOT always the true front window.    � ��� �   i n v o l v e d ,   s a d l y ,   ` f r o n t   w i n d o w `   i s   N O T   a l w a y s   t h e   t r u e   f r o n t   w i n d o w .  � ��� r   � ���� m   � ��%�% � o      �$�$ *0 indexoftruefrontwin indexOfTrueFrontWin� ��� Y   ���#���"� Z   ����!� � =  ���� n   � ���� 1   � ��
� 
pnam� l  � ����� n   � ���� 4   � ���
� 
cobj� o   � ��� 0 ndx  � o   � ��� 0 	wapp_list  �  �  � n   ���� 1  �
� 
pnam� o   ��� 0 wproc_current  � k  �� ��� r  ��� o  
�� 0 ndx  � o      �� *0 indexoftruefrontwin indexOfTrueFrontWin� ���  S  �  �!  �   �# 0 ndx  � m   � ��� � o   � ��� 
0 wcount  �"  � ��� l ����  � 6 0# log "true front index: " & indexOfTrueFrontWin   � ��� ` #   l o g   " t r u e   f r o n t   i n d e x :   "   &   i n d e x O f T r u e F r o n t W i n� ��� r  ��� m  �
� boovtrue� o      �� 0 ok  �  �   S  �  �+  � Z   ~� =  ' l  %�� n   % 1  #%�
� 
pnam o   #�
�
 0 wproc_current  �  �   o  %&�	�	 "0 wapp_targetname wapp_targetName k  *z		 

 l **��   9 3# log "processing: [" & name of wproc_current & "]"    � f #   l o g   " p r o c e s s i n g :   [ "   &   n a m e   o f   w p r o c _ c u r r e n t   &   " ] "  O  *t k  0s  r  0A e  0= n  0= 1  8<�
� 
valL 4  08�
� 
attr m  47 �  A X F u l l S c r e e n o      �� 0 isfullscreen isFullScreen  Z BP !��  o  BC�� 
0 toggle  ! r  FL"#" H  FJ$$ o  FI�� 0 isfullscreen isFullScreen# o      � �  0 turnon turnOn�  �   %��% Z  Qs&'��(& > QV)*) o  QT���� 0 isfullscreen isFullScreen* o  TU���� 0 turnon turnOn' k  Yo++ ,-, l YY��./��  . . (# log "setting fullscreen to: " & turnOn   / �00 P #   l o g   " s e t t i n g   f u l l s c r e e n   t o :   "   &   t u r n O n- 121 r  Yg343 o  YZ���� 0 turnon turnOn4 n      565 1  bf��
�� 
valL6 4  Zb��7
�� 
attr7 m  ^a88 �99  A X F u l l S c r e e n2 :��: l ho;<=; I ho��>��
�� .sysodelanull��� ��� nmbr> m  hk?? ?�333333��  < d ^ For good measure; it seems turning fullscreen *on* sometimes fails (you'll hear a pop sound).   = �@@ �   F o r   g o o d   m e a s u r e ;   i t   s e e m s   t u r n i n g   f u l l s c r e e n   * o n *   s o m e t i m e s   f a i l s   ( y o u ' l l   h e a r   a   p o p   s o u n d ) .��  ��  ( l rr��AB��  A  # log "no change needed"   B �CC 0 #   l o g   " n o   c h a n g e   n e e d e d "��   o  *-���� 0 wproc_current   DED r  uxFGF m  uv��
�� boovtrueG o      ���� 0 ok  E H��H  S  yz��  �   l }}��IJ��  I f `# log "no match; waiting for '" & wapp_targetName & "', actual: '" & name of wproc_current & "'"   J �KK � #   l o g   " n o   m a t c h ;   w a i t i n g   f o r   ' "   &   w a p p _ t a r g e t N a m e   &   " ' ,   a c t u a l :   ' "   &   n a m e   o f   w p r o c _ c u r r e n t   &   " ' "�,  � R      ������
�� .ascrerr ****      � ****��  ��  �9  �:  �M 0 attempt  T m   � ����� U o   � ����� 0 	max_tries 	MAX_TRIES�L  R L��L l ����MN��  M y sif not ok then error "Obtaining process window '" & wapp_targetName & "' of application " & appName & " timed out."   N �OO � i f   n o t   o k   t h e n   e r r o r   " O b t a i n i n g   p r o c e s s   w i n d o w   ' "   &   w a p p _ t a r g e t N a m e   &   " '   o f   a p p l i c a t i o n   "   &   a p p N a m e   &   "   t i m e d   o u t . "��  �k  �n 0 i   m   d e����   [   e hPQP o   e f���� 
0 wcount  Q m   f g���� �m  �o   � 4   N R��R
�� 
prcsR o   P Q���� 0 appname appName � m   J KSS�                                                                                  sevs  alis    �  Macintosh HD               ���PH+   C�System Events.app                                               GP��Y        ����  	                CoreServices    ��G�      ���     C� C� C�  =Macintosh HD:System: Library: CoreServices: System Events.app   $  S y s t e m   E v e n t s . a p p    M a c i n t o s h   H D  -System/Library/CoreServices/System Events.app   / ��   � . ( Target *all* the application's windows.    � �TT P   T a r g e t   * a l l *   t h e   a p p l i c a t i o n ' s   w i n d o w s . � UVU ?  ��WXW o  ������ 
0 wcount  X m  ������  V Y��Y l �5Z[\Z O  �5]^] O  �4_`_ k  �3aa bcb l ����de��  d ^ X NOTE: We MUST activate the application in case its active window is in fullscreen mode.   e �ff �   N O T E :   W e   M U S T   a c t i v a t e   t h e   a p p l i c a t i o n   i n   c a s e   i t s   a c t i v e   w i n d o w   i s   i n   f u l l s c r e e n   m o d e .c ghg l ����ij��  i o i       Bizzarrely, without activating, we would not gain access to that active window's *process* window.   j �kk �               B i z z a r r e l y ,   w i t h o u t   a c t i v a t i n g ,   w e   w o u l d   n o t   g a i n   a c c e s s   t o   t h a t   a c t i v e   w i n d o w ' s   * p r o c e s s *   w i n d o w .h lml r  ��non m  ����
�� boovtrueo 1  ����
�� 
pisfm pqp r  ��rsr m  ����
�� boovfalss o      ���� 0 ok  q tut Y  �v��wx��v k  �yy z{z l ��|}~| I ������
�� .sysodelanull��� ��� nmbr m  ���� ?ə�������  } � � Note: Only when the active window is currently in fullscreen mode are several iterations needed - presumably, because switching to that window's space takes time.   ~ ���F   N o t e :   O n l y   w h e n   t h e   a c t i v e   w i n d o w   i s   c u r r e n t l y   i n   f u l l s c r e e n   m o d e   a r e   s e v e r a l   i t e r a t i o n s   n e e d e d   -   p r e s u m a b l y ,   b e c a u s e   s w i t c h i n g   t o   t h a t   w i n d o w ' s   s p a c e   t a k e s   t i m e .{ ���� Q  ������ k  ��� ��� l ��������  � e _ Obtain the same window as a *process* window, as only a process window allows us to examine or   � ��� �   O b t a i n   t h e   s a m e   w i n d o w   a s   a   * p r o c e s s *   w i n d o w ,   a s   o n l y   a   p r o c e s s   w i n d o w   a l l o w s   u s   t o   e x a m i n e   o r� ��� l ��������  �    change fullscreen status.   � ��� 4   c h a n g e   f u l l s c r e e n   s t a t u s .� ��� O  �	��� l ����� k  ��� ��� r  ����� e  ���� n  ����� 1  ����
�� 
valL� 4  �����
�� 
attr� m  ���� ���  A X F u l l S c r e e n� o      ���� 0 isfullscreen isFullScreen� ��� Z ��������� o  ������ 
0 toggle  � r  ����� H  ���� o  ������ 0 isfullscreen isFullScreen� o      ���� 0 turnon turnOn��  ��  � ���� Z  �������� > ����� o  ������ 0 isfullscreen isFullScreen� o  ������ 0 turnon turnOn� r  ���� o  ������ 0 turnon turnOn� n      ��� 1  ���
�� 
valL� 4  �����
�� 
attr� m  ���� ���  A X F u l l S c r e e n��  ��  ��  � N H Note: This can fail before switching to a fullscreen space is complete.   � ��� �   N o t e :   T h i s   c a n   f a i l   b e f o r e   s w i t c h i n g   t o   a   f u l l s c r e e n   s p a c e   i s   c o m p l e t e .� 4 �����
�� 
cwin� m  ������ � ��� r  
��� m  
��
�� boovtrue� o      ���� 0 ok  � ����  S  ��  � R      ������
�� .ascrerr ****      � ****��  ��  ��  ��  �� 0 attempt  w m  ������ x o  ������ 0 	max_tries 	MAX_TRIES��  u ���� Z 3������� H   �� o  ���� 0 ok  � R  #/�����
�� .ascrerr ****      � ****� b  %.��� b  %*��� m  %(�� ��� \ O b t a i n i n g   a c t i v e   p r o c e s s   w i n d o w   o f   a p p l i c a t i o n� o  ()���� 0 appname appName� m  *-�� ���    t i m e d   o u t .��  ��  ��  ��  ` 4  �����
�� 
prcs� o  ������ 0 appname appName^ m  �����                                                                                  sevs  alis    �  Macintosh HD               ���PH+   C�System Events.app                                               GP��Y        ����  	                CoreServices    ��G�      ���     C� C� C�  =Macintosh HD:System: Library: CoreServices: System Events.app   $  S y s t e m   E v e n t s . a p p    M a c i n t o s h   H D  -System/Library/CoreServices/System Events.app   / ��  [ 6 0 Target *current* window only (if there is one).   \ ��� `   T a r g e t   * c u r r e n t *   w i n d o w   o n l y   ( i f   t h e r e   i s   o n e ) .��  �|  �}  ��       �������  � ������ 0 setfullscreen setFullScreen
�� .aevtoappnull  �   � ****� �� ����������� 0 setfullscreen setFullScreen�� ����� �  �������� 0 appname appName�� @0 zeroforoffoneforontwofortoggle zeroForOffOneForOnTwoForToggle�� 0 
allwindows 
allWindows��  � ������������������������������������������ 0 appname appName�� @0 zeroforoffoneforontwofortoggle zeroForOffOneForOnTwoForToggle�� 0 
allwindows 
allWindows�� 0 	wapp_list  �� 
0 wcount  �� 0 	max_tries 	MAX_TRIES�� 
0 toggle  �� 0 turnon turnOn�� *0 indexoftruefrontwin indexOfTrueFrontWin�� 0 wproc_target  �� $0 wproc_targetname wproc_targetName�� 0 i  �� 0 ok  �� 0 
wapp_index  �� 0 wapp_target  �� "0 wapp_targetname wapp_targetName�� 0 attempt  �� 0 wproc_current  �� 0 ndx  �� 0 isfullscreen isFullScreen� �������������S�������������������8?�������
�� 
capp
�� 
cwin�  
�� 
pvis
�� .corecnte****       ****�� 
�� 
bool
�� 
prcs
�� 
msng
�� 
cobj
�� 
pnam
�� 
pidx
�� 
pisf
�� .sysodelanull��� ��� nmbr
�� 
attr
�� 
valL��  �  ��:*�/ *�-�[�,\Ze81E�O�j E�OPUO�E�O�l E�OfE�O� 
�k E�Y hO�	 �k�&P�H*�/@iE�O�E�O�E�O1j�kkh �j	 �� �& hYfE�O�j '�E�O��k  �E�Y hO��/EE�O��,EE�Y hO �k�kh �j 
k��,FY hOe*�,FO�j O �*�k/E^ O�j  :kE�O *k�kh ��] /�,] �,  ] E�OY h[OY��OeE�OY `] �,�  U]  E*a a /a ,EE^ O� ] E�Y hO] � �*a a /a ,FOa j Y hUOeE�OY hW X  h[OY�-OP[OY��UUY ��j �� �*�/ �e*�,FOfE�O ik�kh �j O N*�k/ =*a a /a ,EE^ O� ] E�Y hO] � �*a a /a ,FY hUOeE�OW X  h[OY��O� )ja �%a %Y hUUY h� �~��}�|���{
�~ .aevtoappnull  �   � ****� k     ���  ��  "��  3��  F�z�z  �}  �|  � �y�x�y 0 proc  �x 0 i  �        �w�v * . 1�u ; ? B�t ��s�r�q�p�o�n�m�l�k�j�w �v 0 	blacklist 	blackList�u 0 	javanames 	javaNames�t 0 	realnames 	realNames
�s 
prcs
�r 
kocl
�q 
cobj
�p .corecnte****       ****
�o 
bkgo
�n 
pnam�m 0 procname procName�l 0 setfullscreen setFullScreen�k  �j  �{ ��������vE�O���mvE�O���mvE�Oa  � �*a -[a a l kh   }�a ,f  o c�a ,E` O�_  5 /k�j kh �a �/_   �a �/E` OY h[OY��Y hO�_  )_ jem+ Y hW X  hY hW X  h[OY�vUascr  ��ޭ